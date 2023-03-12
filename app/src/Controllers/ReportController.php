<?php

namespace App\Controllers;
use App\Controllers\Controller;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;

class ReportController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/reports', function (\Slim\App $route) {
            $route->get('/exportby', "ReportController:exportByRange")->setName('reports.exportby');
        });
    }

    public function exportByRange($request, $response) {
        $settings = \TabledefaultsettingQuery::create()->findOne();
        if (!isset($_REQUEST['q'])) {
            return $response;
        }

        if ($_REQUEST['q'] == 'month')  {
            $dateStart = $settings->getDateMonthStart()->format('Y-m-d');
            $dateEnd = $settings->getDateMonthEnd()->format('Y-m-d');
        }

        if ($_REQUEST['q'] == 'year')  {
            $dateStart = $settings->getDateYearStart()->format('Y-m-d');
            $dateEnd = $settings->getDateYearEnd()->format('Y-m-d');
        }

        $headers = ['Date','Company Name', 'SumOfGST Collected', 'Sales', 'Total'];

        $export = <<<EOT
                SELECT 
                FORMAT([Date], 'dd/MM/yyyy') as 'Date'
                ,[Company Name]
                , FORMAT(Sum([Table Transaction Items].[GST Collected]), 'C') as 'SumOfGST Collected'
                , FORMAT(Sum([Table Transaction Items].Credit), 'C') as 'Sales'
                , FORMAT(Sum([Table Transaction Items].[GST Collected] + [Table Transaction Items].Credit), 'C') as 'Total'
            FROM [business].[dbo].[Table Transaction Main]
            left join [business].[dbo].[Table Transaction Items Title] on [business].[dbo].[Table Transaction Main].[Transaction ID] = [Table Transaction Items Title].TransactionNo
            left join [business].dbo.[Table Transaction Items] on [Table Transaction Items Title].[Title No] = [Table Transaction Items].[Title Item]
            left join [business].dbo.[Table Company Detail] on [business].[dbo].[Table Transaction Main].[Company No] = [business].dbo.[Table Company Detail].[Company ID]
            where [Date] >= ? and [Date] <= ?
            group by  TransactionNo, [Company Name], [Date], [Payment No]
        EOT;

        $con = Propel::getServiceContainer()->getReadConnection('default');        
        
        $stmt = $con->prepare(trim($export));
        $stmt->bindParam(1, $dateStart);
        $stmt->bindParam(2, $dateEnd);
        $stmt->execute();
        
        // !ddd($stmt->fetchAll(\PDO::FETCH_ASSOC));

        $this->createCSVFile([
            'start' => $settings->getDateMonthStart()->format('Y'),
            'end' => $settings->getDateMonthEnd()->format('Y'),
            'headers' => $headers,
            'title' => 'GR Morelli - Export By' . $_REQUEST['q'],
            'data' => $stmt->fetchAll(\PDO::FETCH_ASSOC)
        ]);
    }

    public function createCSVFile($data) {
        $filename = $data['title'] . ' ' . $data['start']. '-' . $data['end'];
        $filepath = $_SERVER["DOCUMENT_ROOT"] . $filename . '.csv';
        $output = fopen($filepath, 'w+');

        $totals = 0;
        fputcsv($output, $data['headers']);
        foreach ($data['data'] as $key => $line) {
            $totals += floatval($line['Total']);
            fputcsv($output, $line);
        }

        fclose($output);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        header('Content-Length: ' . filesize($filepath)); 
        echo readfile($filepath);
    }
}