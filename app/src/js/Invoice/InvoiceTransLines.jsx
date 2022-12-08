import React from "react";
import InvoiceTransLine from "./InvoiceTransLine";

function InvoiceTransLines({ trans, expensecodes }) {
  // console.log(">>> Transactions", trans);
  return (
    <div className="overflow-x-auto">
      <table className="table table-normal w-full" id="translines">
        <thead>
          <tr>
            <th className="text-center w-10">Item No</th>
            <th className="text-center w-10">Item</th>
            <th className="text-center w-3/6">Description</th>
            <th className="text-center w-10">Tax%</th>
            <th className="text-center w-10">GST</th>
            <th className="text-center w-1/6">Cost</th>
            <th className="text-center w-1/6">Expense</th>
            <th>
              <a
                className="btn btn-primary"
                onClick={() => console.log("new line btn clicked")}
              >
                +
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          {trans.map((tran) => {
            console.log(">>> Transactions", tran);
            tran.Lines.map((line) => {
              console.log(">>> Lines", line);
              <InvoiceTransLine
                tran={tran}
                line={line}
                key={line.Id}
                expensecodes={expensecodes}
              />;
            });
          })}
        </tbody>
      </table>
    </div>
  );
}

export default InvoiceTransLines;
