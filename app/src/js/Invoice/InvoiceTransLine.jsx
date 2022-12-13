import React from "react";

function InvoiceTransLine({ line, expensecodes }) {
  console.log(">>> InvoiceTransLine", line, expensecodes);
  return (
    <>
      <tr className="hover" data-headid={line.TitleItem}>
        <td>{line.TitleItem}</td>
        <td>{line.Item}</td>
        <td>
          <textarea
            className="textarea textarea-bordered w-full"
            name=""
            id=""
            rows="3"
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
            <span
              className="cost input input-bordered w-full text-right"
              defaultValue={parseFloat(line.Credit).toFixed(2)}
            >
              {parseFloat(line.Credit).toFixed(2)}
            </span>
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
