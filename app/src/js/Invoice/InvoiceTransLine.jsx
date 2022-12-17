import React, { useEffect, useState } from "react";
import axios from "axios";

function InvoiceTransLine({ route, line, expensecodes }) {
  // console.log(">>> InvoiceTransLine", line, expensecodes);
  const [itemline, setItemline] = useState([]);

  useEffect(() => {
    setItemline(line);
  }, [line]);

  function updateGst(e) {
    let elem = e.target;
    let tr = elem.closest("tr");
    console.log(">>> Changed Cost", tr);
  }

  async function saveRow(e) {
    let tr = e.target.closest("tr");
    let elems = tr.querySelectorAll("input, select, textarea");

    let form = new FormData();
    elems.forEach((ele) => {
      form.append(ele.name, ele.value);
    });

    form.append("TitleItem", itemline.TitleItem);
    form.append("Item", itemline.Item);
    form.append("Id", itemline.Id);

    // for (let [name, value] of form) {
    //   console.log(`${name} = ${value}`);
    // }

    // console.log(elems, route.itemsave);
    await axios.post(route.itemsave, form).then((res) => {
      console.log(">>> Save ItemLine", res);
      setItemline(res.data.data);
    });
  }

  return (
    <>
      <tr className="hover" data-headid={line.Id} onChange={(e) => saveRow(e)}>
        <td>{itemline.TitleItem}</td>
        <td>{itemline.Item}</td>
        <td>
          <textarea
            className="textarea textarea-bordered w-full"
            name="Description"
            id=""
            rows="2"
            defaultValue={itemline.Description}
          ></textarea>
        </td>
        <td>
          <span className="tax">
            {itemline.Tax != undefined
              ? (parseFloat(itemline.Tax) * 100).toFixed(2)
              : "0.00"}
          </span>
          %
        </td>
        <td>
          <span className="money">
            {itemline.GstCollected != undefined
              ? parseFloat(itemline.GstCollected).toFixed(2)
              : "0.00"}
          </span>
        </td>
        <td>
          <label className="input-group">
            <span>$</span>
            <input
              className="cost input input-bordered w-full text-right"
              name="Credit"
              type="number"
              step=".01"
              defaultValue={parseFloat(itemline.Credit).toFixed(2)}
              onChange={(e) => updateGst(e)}
            />
          </label>
        </td>
        <td>
          <select
            name="Expense"
            id=""
            className="input input-bordered w-full"
            defaultValue={itemline.Expense}
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
