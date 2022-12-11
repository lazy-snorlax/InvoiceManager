import React from "react";
import axios from "axios";
import BusinessLogo from "./BusinessLogo";

function BusinessForm({ data, route }) {
  console.log("Business Form", data, route);

  const saveOnChange = () => {
    let form = document.querySelector("form");
    let formData = new FormData(form);
    console.log("Changed", form);

    axios
      .post(route, formData)
      .then((response) => {
        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      });
  };

  return (
    <div>
      <form data-name="Tablebusinessdetail" onChange={() => saveOnChange()}>
        <div className="flex space-x-4">
          <div className="mb-4 w-1/4" hidden>
            <label htmlFor="BusinessId" className="label">
              <span className="label-text">Business ID:</span>
            </label>
            <input
              type="number"
              className="input input-bordered w-full"
              disabled
              name="BusinessId"
              data-type="integer"
              required="required"
              defaultValue={data.BusinessId}
            />
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="BusinessName">
              <span className="label-text"> Business Name:</span>
            </label>
            <input
              type="input"
              className="input input-bordered w-full"
              name="BusinessName"
              data-type="varchar"
              defaultValue={data.BusinessName}
            />
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="ContactName">
              <span className="label-text">Contact:</span>
            </label>
            <input
              type="input"
              className="input input-bordered w-full"
              name="ContactName"
              data-type="varchar"
              defaultValue={data.ContactName}
            />
          </div>
          <div className="mb-4 w-2/4">
            <label className="label" htmlFor="EmailAddress1">
              <span className="label-text">Email:</span>
            </label>
            <input
              type="input"
              className="input input-bordered w-full"
              name="EmailAddress1"
              data-type="varchar"
              defaultValue={data.EmailAddress1}
            />
          </div>
        </div>

        <div className="flex space-x-4">
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="Phone1">
              <span className="label-text">Phone:</span>
            </label>
            <input
              type="input"
              className="input input-bordered w-full"
              name="Phone1"
              data-type="varchar"
              defaultValue={data.Phone1}
            />
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="Mobile1">
              <span className="label-text">Mobile:</span>
            </label>
            <input
              type="input"
              className="input input-bordered w-full"
              name="Mobile1"
              data-type="varchar"
              defaultValue={data.Mobile1}
            />
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="Abn1">
              <span className="label-text">ABN:</span>
            </label>
            <input
              type="input"
              className="input input-bordered w-full"
              name="Abn1"
              data-type="varchar"
              defaultValue={data.Abn1}
            />
          </div>
        </div>

        <div className="flex space-x-4">
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="Address1">
              <span className="label-text">Address:</span>
            </label>
            <input
              className="input input-bordered w-full"
              name="Address1"
              data-type="varchar"
              defaultValue={data.Address1}
            />
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="City1">
              <span className="label-text">City:</span>
            </label>
            <input
              className="input input-bordered w-full"
              name="City1"
              data-type="varchar"
              defaultValue={data.City1}
            />
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="State1">
              <span className="label-text">State:</span>
            </label>
            <input
              className="input input-bordered w-full"
              name="State1"
              data-type="varchar"
              defaultValue={data.State1}
            />
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="PostCode1">
              <span className="label-text">Post Code:</span>
            </label>
            <input
              className="input input-bordered w-full"
              name="PostCode1"
              data-type="varchar"
              defaultValue={data.PostCode1}
            />
          </div>
        </div>

        <div className="flex space-x-4">
          <div className="mb-4 w-2/4">
            <label className="label" htmlFor="Note1">
              <span className="label-text">Note:</span>
            </label>
            <textarea
              className="textarea textarea-bordered w-full"
              name="Note1"
              data-type="varchar"
              defaultValue={data.Note1}
              rows="3"
            />
          </div>
          <div className="mb-4 w-2/4">
            <label className="label" htmlFor="Note2">
              <span className="label-text">Note:</span>
            </label>
            <textarea
              className="textarea textarea-bordered w-full"
              name="Note2"
              data-type="varchar"
              defaultValue={data.Note2}
              rows="3"
            />
          </div>
        </div>
      </form>

      <BusinessLogo route={route} img={data.ImgLoc} />
    </div>
  );
}

export default BusinessForm;
