@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            Generate API Token
          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('tokens.store') }}">
              <div class="form-group">
                <label>Token Name</label>
                <input id="token" type="text" name="token_name" class="w-100" required
                  id="token">
              </div>

              <button id="submit" type="submit" class="btn btn-primary mt-2">
                Submit
              </button>
            </form>

            <div class="w-100 d-flex">
              <div class="spinner-border mx-auto text-primary d-none" id="spinner" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            <div class="d-none mt-3" id="output">
              <p>API Token Generated:</p>
              <p class="text-primary"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {
      const tokenName = document.getElementById('token');
      const btn = document.getElementById('submit');
      const output = document.getElementById('output');
      const spinner = document.getElementById('spinner');
      btn.onclick = async (e) => {
        e.preventDefault();
        console.log('hey');
        spinner.classList.remove('d-none');
        const res = await axios.post("{{ route('tokens.store') }}", {
          token_name: tokenName.value,
        });
        spinner.classList.add('d-none');
        output.classList.remove('d-none');
        output.childNodes[2].innerText = res.data.token;
      }
    });
    </script>