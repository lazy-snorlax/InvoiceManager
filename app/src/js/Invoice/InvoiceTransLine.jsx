import React, { useEffect, useState } from "react";
import axios from "axios";
import PropTypes from "prop-types";
import InvoiceTransLines from "./InvoiceTransLines";

function InvoiceTransLine(props) {
  // console.log(">>> InvoiceTransLine", line, expensecodes); { route, line, expensecodes, getTotals }
  const [itemline, setItemline] = useState([]);
  const { totals, getTotals } = props.getTotals;

  useEffect(() => {
    setItemline(props.line);
  }, [props.line]);

  async function saveRow(e) {
    let tr = e.target.closest("tr");
    let elems = tr.querySelectorAll("input, select, textarea");

    let form = new FormData();
    elems.forEach((ele) => {
      form.append(ele.name, ele.value);
    });

    // form.append("Tax", parseFloat(itemline.Tax));
    form.append("TitleItem", itemline.TitleItem);
    form.append("Item", itemline.Item);
    form.append("Id", itemline.Id);

    // for (let [name, value] of form) {
    //   console.log(`${name} = ${value}`);
    // }

    await axios.post(props.route.itemsave, form).then((res) => {
      console.log(">>> Save ItemLine", res);
      setItemline(res.data.data);
    });

    props.getTotals(itemline.TitleItem);
  }

  return (
    <>
      <tr
        className="hover"
        data-headid={props.line.Id}
        onChange={(e) => saveRow(e)}
      >
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
          <label className="input-group">
            <input
              type="number"
              name="Tax"
              // disabled
              className="input input-bordered w-full"
              defaultValue={
                itemline.Tax != undefined
                  ? (parseFloat(itemline.Tax) * 100).toFixed(2)
                  : "10.00"
              }
            />
            <span>%</span>
          </label>
        </td>
        <td className="text-center">
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
              defaultValue={
                itemline.Credit != undefined
                  ? parseFloat(itemline.Credit).toFixed(2)
                  : console.log(itemline.Credit)
              }
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
            {props.expensecodes.map((exp) => (
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
