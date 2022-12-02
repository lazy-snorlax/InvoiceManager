import React, { useContext } from "react";

function TableRow({ data }) {
  return (
    <tr className="hover">
      <td>{data.TransactionId}</td>
      <td>{data.Company ? data.Company.CompanyName : ""}</td>
      <td>{data.Date}</td>
      <td>{data.Paid ? "✔️" : "❌"}</td>
      <td>
        <label htmlFor="invoiceModal" className="btn btn-primary">
          Open
        </label>
      </td>
    </tr>
  );
}

export default TableRow;
