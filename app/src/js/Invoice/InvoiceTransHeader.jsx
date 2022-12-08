import React, { useState, useEffect } from "react";
import axios from "axios";

function InvoiceTransHeader({ trans }) {
  //   console.log(">>> Transactions", trans, route);

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
        // ele.classList.remove("active");
      } else {
        ele.removeAttribute("hidden");
        // ele.classList.add("active");
      }
    });
  };

  filterRows(trans[0].TitleNo);

  return (
    <>
      <div className="overflow-x-auto">
        <table className="table table-normal w-full">
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
                onClick={() => {
                  // row.classList.remove("active");
                  filterRows(tran.TitleNo);
                  // row.classList.add("active");
                }}
              >
                <td>{tran.TitleNo}</td>
                <td colSpan={2}>{tran.TitleDescription}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </>
  );
}

export default InvoiceTransHeader;
