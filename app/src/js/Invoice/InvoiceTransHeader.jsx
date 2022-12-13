import React, { useState, useEffect } from "react";
import axios from "axios";
import InvoiceTransLines from "./InvoiceTransLines";

function InvoiceTransHeader({ trans, route, routeExpcodes }) {
  // console.log(">>> ", trans, route);
  const [id, setId] = useState();
  const [tranlines, setLines] = useState([]);

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
    </>
  );
}

export default InvoiceTransHeader;
