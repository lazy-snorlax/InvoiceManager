import React, { useState, useEffect } from "react";
import axios from "axios";
import InvoiceTransLines from "./InvoiceTransLines";

function InvoiceTransHeader({ trans, route, routeExpcodes }) {
  // console.log(">>> ", trans, route);
  const [id, setId] = useState();
  const [tranlines, setLines] = useState([]);
  const [gst, setGst] = useState();
  const [credit, setCredit] = useState();
  const [total, setTotal] = useState();

  //   useEffect(() => {
  //     async function fetchData() {
  //       console.log(">>> ExpenseCodes", tblExpensecodes.data);
  //     }
  //     fetchData();
  //   }, []);

  const filterRows = (rowId) => {
    let translines = document.querySelectorAll("#translines tbody tr");
    translines.forEach((ele) => {
      if (ele.dataset.headid != rowId) {
        ele.setAttribute("hidden", true);
      } else {
        ele.removeAttribute("hidden");
      }
    });
  };

  async function fetchLines(lineId) {
    // console.log(">>> fetchLines", lineId);
    const tblLines = await axios(route + "?id=" + lineId);
    console.log(">>> tblLines", tblLines.data.lines);
    setLines(tblLines.data.lines);
    setGst(tblLines.data.gstTotal);
    setCredit(tblLines.data.creditTotal);
    setTotal(tblLines.data.total);
    console.log(total);
  }

  function toggleActive(e) {
    let activeRow = e.target;
    activeRow = activeRow.closest("tr");
    console.log(activeRow);
    let previousRow = document.querySelector("#transheader tr.active");
    if (previousRow && previousRow.classList.contains("active")) {
      previousRow.classList.toggle("active");
    }
    activeRow.classList.toggle("active");
  }

  return (
    <>
      <div className="overflow-x-auto h-60">
        <table className="table table-normal w-full" id="transheader">
          <thead>
            <tr>
              <th>No</th>
              <th>TitleDescription</th>
              <th className="text-right">
                <button
                  type="button"
                  className="btn btn-primary"
                  onClick={() => console.log("new head btn clicked")}
                >
                  +
                </button>
              </th>
            </tr>
          </thead>
          <tbody>
            {trans.map((tran) => (
              <tr
                className="hover"
                key={tran.TitleNo}
                onClick={(e) => {
                  toggleActive(e);
                  fetchLines(tran.TitleNo);
                }}
              >
                <td>{tran.TitleNo}</td>
                <td colSpan={2}>{tran.TitleDescription}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      <br />

      <InvoiceTransLines
        lineId={id}
        route={route}
        lines={tranlines}
        routeExpcodes={routeExpcodes}
      />

      <div className="mt-4 flex space-x-4 text-right">
        <div className="w-6/12"></div>
        <div className="mb-4 w-2/12">
          <label htmlFor="ItemGST" className="label">
            Item GST
          </label>
          <label className="input-group">
            <span>$</span>
            <input
              type="number"
              step=".01"
              disabled="true"
              name="ItemGST"
              id="ItemGST"
              className="input input-bordered w-full text-right"
              defaultValue={gst}
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
              disabled="true"
              name="ItemGST"
              id="ItemGST"
              className="input input-bordered w-full text-right"
              defaultValue={credit}
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
              disabled="true"
              name="ItemGST"
              id="ItemGST"
              className="input input-bordered w-full text-right"
              defaultValue={total}
            />
          </label>
        </div>
      </div>
    </>
  );
}

export default InvoiceTransHeader;
