@extends('service.layouts.master')
@section('title', 'Home')
@section('content')

<section class="gen-section">
    <div class="gen-wrap">
        <div class="topHeading indexBar xy-between mb-5">
            <div class="leftWrap">
                <h1 class="headingMain">Blogs</h1>
            </div>
            <a href="#newblogModal" data-bs-toggle="modal" class="genBtn type2 bookBtn" type="button">Create New Blog</a>
        </div>
        <div class="row blogRow">

            @if ($blogs->isNotEmpty())
            @foreach($blogs as $blog)

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="blogCard">
                    <a href="{{url('service/blog', $blog->id)}}" class="imgBox">
                        <img src="{{asset($blog->blog_image)}}" alt="img">
                    </a>
                    <div class="textBox">
                        <p class="title">{{$blog->sub_category->title}}</p>
                        <p class="desc">{{$blog->truncated}}<a href="{{url('service/blog', $blog->id)}}">Read More</a></p>

                        <div class="bottomRow pt-3 mt-3 row align-items-center">
                            <div class="col-6">
                                <div class="blogPoster d-flex align-items-center">
                                    <img src="{{$blog->user->profile_image ? asset($blog->user->profile_image) : asset('assets/images/mem1.png')}}" alt="img">
                                    <p class="name">{{$blog->user->first_name }} {{$blog->user->last_name }}</p>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <div class="xy-end ">
                                    <img src="{{asset('assets/images/nav-icon-2.png')}}" alt="img">
                                    <p class="date ms-2">{{$blog->created_at->format('j F Y')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            @else
            <p class="noData">Data not found</p>

            @endif




        </div>
    </div>
</section>


<!-- Create New Blogs Modal Start-->
<div class="modal fade genModal" id="newblogModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="headingMain text-center pt-4 pb-3">Create New Blog</p>
                <form class="paymentForm row" id="save_blog_form" enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="uploadBox mb-3">
                            <label id="wrapper" for="fileUpload" class="xy-center">
                                <img src="{{asset('assets/images/uploadIcon.png')}}" alt="img">
                                <p class="pt-2">Upload Image</p>
                                <input id="fileUpload" name="blog_image" class="d-none" type="file" accept="image/gif, image/jpeg, image/png">
                            </label>

                        </div>
                        <div id="image-holder" class="pb-2"></div>
                    </div>
                    @csrf
                    <div class="col-12">
                        <div class="form-group logInput mb-3">

                            <select id="category_id" name="category_id" class="input1 ps-4">
                                <option selected disabled value="">--Category--</option>
                                @if(count($categories))
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                                @endif
                            </select>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group logInput mb-3">
                            <select class="input1 ps-4" id="sub_category_id" name="sub_category_id">
                                <option selected disabled>-- Select Category First --</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group logInput mb-3">
                            <textarea class="textarea1 input1 ps-4 pt-3" id="description" name="description" placeholder="Description"></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="genBtn type2" id="save_blog" type="button">Save</button>
                    </div>
                </form>
                <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
<!--Create New Blogs Modal End-->
@endsection
@push('scripts')
<script>
    $(document).ready(() => {

        $(document).on('click', '#save_blog', function() {
            var category_id = $('#category_id').val();
            var sub_category_id = $('#sub_category_id').val();
            var description = $('#description').val();

            var image = $("[name='blog_image']")

            if (image[0].files.length == 0) {
                not('Please select image', 'error');
                return;

            } else if (!category_id) {
                not('Please select category', 'error');
                return;
            } else if (!sub_category_id) {
                not('Please select sub category', 'error');
                return;
            } else if (!description) {
                not('Description field can not be empty', 'error');
                return;
            }

            var form = document.getElementById("save_blog_form");

            $.ajax({
                type: "POST",
                url: baseUrl + "/blog",
                data: new FormData(form),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.status > 0) {

                        location.reload();



                        // not(response.message, "success");
                    } else {
                        not(response.message, "error");
                    }
                },
            });


        });
        $(document).on("change", "#category_id", function() {
            var id = $(this).val();

            $.get(
                baseUrl + "/get-sub-categories/" + id,
                function(response) {
                    var options =
                        '<option value="" selected disabled>-- Sub Category --</option>';
                    if (response.length > 0) {
                        $.each(response, function(index, data) {
                            options +=
                                '<option value="' +
                                data.id +
                                '">' +
                                data.title +
                                "</option>";
                        });
                    }
                    $("#sub_category_id").html(options);
                },
                "json"
            );
        });
    });
</script>
@endpush
@stack('scripts')