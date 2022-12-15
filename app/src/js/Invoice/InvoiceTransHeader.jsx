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
  const [head, setHead] = useState({ id: "", text: "" });

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
                <label
                  htmlFor="invoiceTransHead"
                  className="btn btn-primary"
                  onClick={() => {
                    setHead({ id: "0", text: "" });
                  }}
                >
                  +
                </label>
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
                onDoubleClick={(e) => {
                  document.querySelector("#invoiceTransHead").click();
                  let id = e.target.closest("tr").children[0].innerText;
                  let text = e.target.closest("tr").children[1].innerText;
                  console.log("Target", text);
                  setHead({ id: id, text: text });
                }}
              >
                <td>{tran.TitleNo}</td>
                <td colSpan={2}>{tran.TitleDescription}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      <input type="checkbox" id="invoiceTransHead" className="modal-toggle" />
      <div className="modal">
        <div className="modal-box">
          <label
            htmlFor="invoiceTransHead"
            className="btn btn-sm btn-circle absolute right-2 top-2"
          >
            ✕
          </label>
          <h3 className="font-bold text-lg">Enter New Address:</h3>
          <div className="py-4 w-full">
            <label htmlFor="" className="label">
              New Address
            </label>
            <input
              type="text"
              className="input input-bordered w-full"
              defaultValue={head.text}
            />
          </div>
          <div className="modal-action">
            <label htmlFor="invoiceTransHead" className="btn btn-primary">
              Save
            </label>
          </div>
        </div>
      </div>

      <br />

      <InvoiceTransLines
        lineId={id}
        route={route}
        lines={tranlines}
        routeExpcodes={routeExpcodes}
      />

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
              disabled
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
              disabled
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
              disabled
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
