import React from "react";

function InvoiceTransLine({ tran, line, expensecodes }) {
  console.log("InvoiceTransLine");
  return (
    <>
      <tr className="hover" data-headid={tran.TitleNo}>
        <td>{tran.TitleNo}</td>
        <td>{line.Item}</td>
        <td>
          <textarea
            className="textarea textarea-bordered w-full"
            name=""
            id=""
            rows="2"
            defaultValue={line.Description}
          ></textarea>
        </td>
        <td>{(parseFloat(line.Tax) * 100).toFixed(2)}%</td>
        <td>
          <span className="money">
            {parseFloat(line.GstCollected).toFixed(2)}
          </span>
        </td>
        <td>
          <label className="input-group">
            <span>$</span>
            <input
              className="cost input input-bordered w-full text-right"
              defaultValue={parseFloat(line.Credit).toFixed(2)}
            />
          </label>
        </td>
        <td>
          <select
            name=""
            id=""
            className="input input-bordered w-full"
            defaultValue={line.Expense}
          >
            {expensecodes.map((exp) => (
              <option value={exp.ExpenseCode} key={exp.ExpenseCode}>
                {exp.ExpenseDescription}
              </option>
            ))}
          </select>
        </td>
        <td></td>
      </tr>
    </>
  );
}

export default InvoiceTransLine;
