import React, { useState } from "react";
import axios from "axios";

function BusinessLogo({ route, img }) {
  const [file, setFile] = useState(img);

  //   useEffect(() => {
  //     const fetchData = async () => {
  //       const picUrl = await axios(route.replace("/save", "?l=true"));
  //       console.log(">>> Pic", picUrl);
  //       // setFile(picUrl);
  //     };
  //     fetchData();
  //   }, []);
  console.log(file, img);

  function handleChange(e) {
    console.log(e.target.files);
    setFile(URL.createObjectURL(e.target.files[0]));

    let uploadFile = document.querySelector("#imageUpload").files[0];

    const data = new FormData();
    data.append("file", uploadFile);

    let url = route + "?img=true";
    axios.post(url, data).then((res) => {
      console.log(res.data);
      setFile(res.data.imgLoc);
    });
  }

  return (
    <>
      <div className="mt-3">
        <img src={file} />
      </div>
      <div className="">
        <label htmlFor="Image" className="label">
          <span className="label-text">Upload New Logo:</span>
        </label>
        <input
          type="file"
          name="Image"
          id="imageUpload"
          className="file-input file-input-bordered w-full max-w-xs"
          onChange={handleChange}
          accept="image/png"
        />
      </div>
    </>
  );
}

export default BusinessLogo;
