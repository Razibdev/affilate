@extends('publisher.layout.dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">

                    <div class="card"
                        style="box-shadow: 0 4px 8px 0 rgb(146 140 175);transition: 0.3s;border: 1px solid #ffefef;">
                        <div class="card-header">
                            <h3>Postback URL</h3>
                        </div>
                        <div class="card-body">
                            <form id="post_back_save" method="post" action="{{ url('publisher/add-postback') }}">
                                @csrf
                                <div class="form-group">

                                    <input type="text" required="" name="postback" value="{{ @$qry->link }}"
                                        placeholder="Enter your Postback URL" class="form-control">
                                    <button class="btn btn-success mt-2" type="submit">Save</button>


                                </div>
                            </form>
                            <p class="postback mt-3"> Example Postback: <b>
                                    https://example.com?&status=<code>{status}</code>&payout=<code>{payout}</code>&hash=<code>{code}</code>&offer_id=<code>{offer_id}</code>&offer_name=<code>{offer_name}</code>&sid=<code>{sid}</code>&sid2=<code>{sid2}</code>&sid3=<code>{sid3}</code>&sid4=<code>{sid4}</code>&sid5=<code>{sid5}</code></b>
                            </p>
                            <p class="postback">Your global postback URL is used to send information about a
                                conversion to your tracking platform. </p>
                            <p class="postback">The following variables are available in your postback:</p>
                            <p class="postback"><code>{offer_id}</code> - Numeric {{ config('app.name') }} Offer ID.
                                Example: 123</p>
                            <p class="postback"><code>{offer_name} </code>- Varchar {{ config('app.name') }} Offer
                                Name. Example: This is a Test Offer Name </p>
                            <p class="postback"><code>{payout}</code> - Numeric {{ config('app.name') }} Payout in
                                USD. Example: 12.00 </p>
                            <p class="postback"><code>{code}</code> - Code means hash variable that is unique.
                                Example:bSvsdf24ffVWE </p>
                            <p class="postback"><code>{sid} </code> - You can send custom value to sid. Example: sid=
                                [YOUR_CUSTOM_DATA] </p>
                            <p class="postback"><code>{sid2}</code> - You can send custom value to sid2. Example:
                                sid2= [YOUR_CUSTOM_DATA] </p>
                            <p class="postback"><code>{sid3}</code> - You can send custom value to sid3. Example:
                                sid3= [YOUR_CUSTOM_DATA]</p>
                            <p class="postback"><code>{sid4}</code> - You can send custom value to sid4. Example:
                                sid4= [YOUR_CUSTOM_DATA]</p>
                            <p class="postback"><code>{sid5}</code> - You can send custom value to sid5. Example:sid5=
                                [YOUR_CUSTOM_DATA] </p>
                            <p class="postback"><code>{status}</code> - We send integer value. 1 or 2 for these
                                purpose. Status. 1)Approved 2)Rejected or Reversed </p>


                            <p class="postback"><code>{ip_address}</code> - {{ $site_setting->site_name }} Ip
                                Address from Visitor. </p>
                            <p class="postback"><code>{ua_target}</code> - {{ $site_setting->site_name }} Device
                                Name. from Visitor </p>
                            <p class="postback"><code>{browsers}</code> - {{ $site_setting->site_name }} Browsers
                                Name. from Visitor </p>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {
            $('#post_back_save').submit(function(e) {
                e.preventDefault();

                let data = $(this).serialize();
                $.ajax({
                    url: "{{ route('publisher.add-postback') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: data,
                    success: function(result) {
                        $('.text-danger').remove();
                        $('.loader').fadeOut();
                        // console.log(result);
                        if (!result.status) {
                            Swal.fire('Failed', result.message, 'error');

                        } else {
                            Swal.fire('Success', result.message, 'success');



                        }
                    },
                    error: function(xhr) {
                        var form = $('#post_back_save');
                        $('.loader').fadeOut();
                        $('.text-danger').remove();
                        if (xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function(k, v) {
                                form.find('[name="' + k + '"]').after(
                                    '<div class="text-danger">' + v[0] +
                                    '</div>');
                            });
                        } else if (xhr.status == 419) {
                            window.location.href = "";
                        }
                        // console.log(xhr);
                    }
                });
            })
        });
    </script>
@endsection
