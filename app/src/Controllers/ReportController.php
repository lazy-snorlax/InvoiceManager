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
            $route->get('/salesby', "ReportController:salesByRange")->setName('reports.salesby');
        });
    }

    public function exportByRange($request, $response) {
        $settings = \TabledefaultsettingQuery::create()->findOne();
        if (!isset($_REQUEST['start'])) {
            return $response;
        }

        $dateStart = $_REQUEST['start'];
        $dateEnd = $_REQUEST['end'];

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
            'title' => 'GR Morelli - Export ' . $dateStart . ' - ' . $dateEnd,
            'data' => $stmt->fetchAll(\PDO::FETCH_ASSOC)
        ]);
    }

    public function salesByRange($request, $response) {
        $settings = \TabledefaultsettingQuery::create()->findOne();
        if (!isset($_REQUEST['start'])) {
            return $response;
        }

        $dateStart = $_REQUEST['start'];
        $dateEnd = $_REQUEST['end'];

        $export = <<<EOT
            SELECT 
                [Company No] as 'CompanyNo'
                ,[Company Name] as 'CompanyName'
                , (Sum([Table Transaction Items].[GST Collected])) as 'GST'
                , (Sum([Table Transaction Items].Credit)) as 'Sales'
                , (Sum([Table Transaction Items].Credit) + Sum([Table Transaction Items].[GST Collected])) as 'Total'
            FROM [business].[dbo].[Table Transaction Main]
            left join [business].[dbo].[Table Transaction Items Title] on [business].[dbo].[Table Transaction Main].[Transaction ID] = [Table Transaction Items Title].TransactionNo
            left join [business].dbo.[Table Transaction Items] on [Table Transaction Items Title].[Title No] = [Table Transaction Items].[Title Item]
            left join [business].dbo.[Table Company Detail] on [business].[dbo].[Table Transaction Main].[Company No] = [business].dbo.[Table Company Detail].[Company ID]
            where [Date] >= ? and [Date] <= ?
            group by [Company No], [Company Name]
            order by [Company No] ASC
        EOT;

        $con = Propel::getServiceContainer()->getReadConnection('default');        
        
        $stmt = $con->prepare(trim($export));
        $stmt->bindParam(1, $dateStart);
        $stmt->bindParam(2, $dateEnd);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $render =  $this->view->render($response, 'reports/salesPDF.twig', [
            'start' => $settings->getDateMonthStart()->format('Y'),
            'end' => $settings->getDateMonthEnd()->format('Y'),
            'title' => 'GR Morelli - Sales By Customer',
            'dates' => [$dateStart, $dateEnd],
            'data' => $result
        ]);
        $this->generatePDF($render);
        die();
    }

    private function generatePDF($request){
        \ini_set("pcre.backtrack_limit", "100000000");
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => __DIR__ . '/tmp',
            // 'mode' => 'c',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_header' => 5,
            'margin_footer' => 5
        ]);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->setFooter('Page {PAGENO} of {nbpg}');
        $mpdf->shrink_tables_to_fit = 1;
        
        $mpdf->WriteHTML($request->getBody());
        $mpdf->Output('Invoice.pdf', \Mpdf\Output\Destination::INLINE);

    }

    public function createCSVFile($data) {
        $filename = $data['title'] . ' ' . $data['start']. '-' . $data['end'];
        $filepath = $_SERVER["DOCUMENT_ROOT"] . $filename . '.csv';
        $output = fopen($filepath, 'w+');

        $totals = 0;
        fputcsv($output, $data['headers']);
        foreach ($data['data'] as $key => $line) {
        //     $totals += floatval($line['Total']);
            fputcsv($output, $line);
        }
        
        if (isset($data['totals'])) {
            fputcsv($output, ['']);
            fputcsv($output, array_keys($data['totals']));
            fputcsv($output, $data['totals']);
        }
        $stat = fstat($output);
        ftruncate($output, $stat['size']-1);
        
        fclose($output);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        header('Content-Length: ' . filesize($filepath)); 
        echo readfile($filepath, false);
    }
   
}