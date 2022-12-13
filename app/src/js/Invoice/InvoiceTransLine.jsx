import React from "react";

function InvoiceTransLine({ line, expensecodes }) {
  // console.log(">>> InvoiceTransLine", line, expensecodes);

  function updateGst(e) {
    let elem = e.target;
    let tr = elem.closest("tr");
    console.log(">>> Changed Cost", tr);
  }

  return (
    <>
      <tr className="hover" data-headid={line.Id}>
        <td>{line.TitleItem}</td>
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
        <td>
          <span className="tax">{(parseFloat(line.Tax) * 100).toFixed(2)}</span>
          %
        </td>
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
              type="number"
              step=".01"
              defaultValue={parseFloat(line.Credit).toFixed(2)}
              onChange={(e) => updateGst(e)}
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
