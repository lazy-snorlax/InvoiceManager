import axios from "axios";
import React, { useState, useEffect } from "react";
import InvoiceTransLine from "./InvoiceTransLine";

function InvoiceTransLines({ route, lines, routeExpcodes }) {
  // console.log(">>> InvoiceTransLines", route, lines, routeExpcodes);
  // const [tranlines, setLines] = useState(lines);
  const [expensecodes, setExpensecodes] = useState([]);

  useEffect(() => {
    async function tblExpensecodes() {
      await axios(routeExpcodes).then((res) => {
        setExpensecodes(res.data.data);
        console.log(expensecodes, routeExpcodes);
      });
    }
    tblExpensecodes();
  }, []);

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
          {lines.map((line) => {
            // console.log(">>> Line", line);
            return (
              <InvoiceTransLine
                key={line.Id}
                line={line}
                expensecodes={expensecodes}
              />
            );
          })}
        </tbody>
      </table>
    </div>
  );
}

export default InvoiceTransLines;
