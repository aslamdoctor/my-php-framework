  <div class="container mt-5">
    <h1>Hello World!</h1>
    <h2><?php echo $name;?></h2>

    <hr />

    <p>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus
      dignissimos esse ipsam sint unde facilis omnis sit repellendus modi
      molestiae.
    </p>

    <p>
      Lorem ipsum dolor, sit amet consectetur adipisicing elit. Possimus,
      omnis?
    </p>

    <form>
      <div class="form-group">
        <label for="exampleFormControlInput1">Email address</label>
        <input
          type="email"
          class="form-control"
          id="exampleFormControlInput1"
          placeholder="name@example.com"
        />
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect1">Example select</label>
        <select class="custom-select" id="exampleFormControlSelect1">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>

      <div class="form-group">
        <label for="exampleFormControlSelect2">Example multiple select</label>
        <select multiple class="form-control" id="exampleFormControlSelect2">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Example textarea</label>
        <textarea
          class="form-control"
          id="exampleFormControlTextarea1"
          rows="3"
        ></textarea>
      </div>

      <div class="custom-control custom-radio">
        <input
          type="radio"
          id="customRadio1"
          name="customRadio"
          class="custom-control-input"
        />
        <label class="custom-control-label" for="customRadio1"
          >Toggle this custom radio</label
        >
      </div>
      <div class="custom-control custom-radio">
        <input
          type="radio"
          id="customRadio2"
          name="customRadio"
          class="custom-control-input"
        />
        <label class="custom-control-label" for="customRadio2"
          >Or toggle this other custom radio</label
        >
      </div>

      <br />

      <div class="custom-control custom-checkbox mr-sm-2">
        <input
          type="checkbox"
          class="custom-control-input"
          id="customControlAutosizing"
        />
        <label class="custom-control-label" for="customControlAutosizing"
          >Check me out</label
        >
      </div>

      <hr />

      <input type="submit" value="Submit" class="the-button" />
    </form>
  </div>
