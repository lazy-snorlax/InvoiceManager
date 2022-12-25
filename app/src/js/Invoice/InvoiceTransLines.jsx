import axios from "axios";
import React, { useState, useEffect } from "react";
import InvoiceTransLine from "./InvoiceTransLine";

function InvoiceTransLines({ lineId, route, lines, routeExpcodes }) {
  // console.log(">>> InvoiceTransLines", lineId, route, lines, routeExpcodes);
  // const [id, setId] = useState({ lineId: lineId });
  const [tranlines, setLines] = useState([]);
  const [expensecodes, setExpensecodes] = useState([]);
  const [totals, setTotals] = useState({});

  useEffect(() => {
    // console.log(">>> ID:", lineId);
    const fetchData = async (id) => {
      const tblExpensecodes = await axios(routeExpcodes);
      const tblLines = await axios(route.lines + "?id=" + id);
      setExpensecodes(tblExpensecodes.data.data);
      setLines(tblLines.data.lines);
      setTotals({
        gst: tblLines.data.gstTotal,
        credit: tblLines.data.creditTotal,
        total: tblLines.data.total,
      });
    };
    fetchData(lineId);
  }, [lineId]);

  async function appendRow() {
    if (lineId == 0) {
      alert("Please select an address to write for");
      return;
    }

    await axios(
      route.lines +
        "?id=" +
        (lineId > 0 ? lineId : lineId + 1) +
        "&newline=true"
    ).then((res) => {
      console.log(res);
      setLines(res.data.lines);
    });
  }

  async function getTotals(id) {
    const tblLines = await axios(route.lines + "?id=" + id);
    setTotals({
      gst: tblLines.data.gstTotal,
      credit: tblLines.data.creditTotal,
      total: tblLines.data.total,
    });
  }

  return (
    <>
      <div className="overflow-x-auto h-64">
        {/* Test {lineId} */}
        <table className="table table-normal w-full" id="translines">
          <thead>
            <tr>
              <th className="text-center w-10">Item No</th>
              <th className="text-center w-10">Item</th>
              <th className="text-center w-2/6">Description</th>
              <th className="text-center w-1/6">Tax%</th>
              <th className="text-center w-1/6">GST</th>
              <th className="text-center w-1/6">Cost</th>
              <th className="text-center w-1/12">Expense</th>
              <th>
                <a
                  className="btn btn-primary"
                  onClick={() => {
                    console.log("new line btn clicked");
                    appendRow();
                  }}
                >
                  +
                </a>
              </th>
            </tr>
          </thead>
          <tbody>
            {tranlines.map((line) => {
              // console.log(">>> Line", line);
              return (
                <InvoiceTransLine
                  key={line.Id}
                  route={route}
                  line={line}
                  getTotals={getTotals.bind(this)}
                  expensecodes={expensecodes}
                />
              );
            })}
          </tbody>
        </table>
      </div>

      <div className="mt-4 flex space-x-4 text-right">
        <div className="w-8/12"></div>
        <div className="mb-4 w-2/12">
          <label htmlFor="ItemGST" className="label">
            Item GST
          </label>
          <label className="input-group">
            <span>$</span>
            <input
              type="number"
              step=".01"
              name="ItemGST"
              id="ItemGST"
              className="input input-bordered w-full text-right"
              defaultValue={totals.gst}
            />
          </label>
        </div>
        <div className="mb-4 w-2/12">
          <label htmlFor="ItemGST" className="label">
            Item Excl Total
          </label>
          <label className="input-group">
            <span>$</span>
            <input
              type="number"
              step=".01"
              name="ItemGST"
              id="ItemGST"
              className="input input-bordered w-full text-right"
              defaultValue={totals.credit}
            />
          </label>
        </div>
        <div className="mb-4 w-2/12">
          <label htmlFor="ItemGST" className="label">
            Item Incl Total
          </label>
          <label className="input-group">
            <span>$</span>
            <input
              type="number"
              step=".01"
              name="ItemGST"
              id="ItemGST"
              className="input input-bordered w-full text-right"
              defaultValue={totals.total}
            />
          </label>
        </div>
      </div>
    </>
  );
}

export default InvoiceTransLines;
