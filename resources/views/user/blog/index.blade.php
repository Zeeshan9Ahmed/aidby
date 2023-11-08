@extends('user.layouts.master')
@section('title', 'Blogs')
@section('content')

<section class="gen-section">
    <div class="gen-wrap">
        <div class="topHeading indexBar xy-between mb-5">
            <div class="leftWrap">
                <h1 class="headingMain">{{ $title }}</h1>
            </div>
            @if($myBlog != null)
            <a href="#newblogModal" data-bs-toggle="modal" class="genBtn type2 bookBtn" type="button">Create New Blog</a>
            @endif
        </div>
        <div class="row">
            @if ($blogs->isNotEmpty())
            @foreach($blogs as $blog)
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="blogCard">
                    <a href="{{ url('user/blog', $blog->id ) }}" class="imgBox">
                        <img src="{{ asset($blog->blog_image) }}" alt="img">
                    </a>
                    <div class="textBox">
                        <p class="title">{{ $blog->sub_category->title }}</p>
                        <p class="desc">{{ $blog->truncated }}<a href="{{ url('user/blog', $blog->id )}}">Read More</a></p>

                        <div class="bottomRow pt-3 mt-3 row align-items-center">
                            <div class="col-6">
                                <div class="blogPoster d-flex align-items-center">
                                @if(!empty($blog->user->profile_image))
                                <img src="{{ asset($blog->user->profile_image) }}" alt="img" class="userImg">
                                @else
                                <img src="{{ asset('assets/images/user-image.png') }}" alt="img" class="userImg">
                                @endif
                                <p class="name">{{ $blog->user->first_name }} {{ $blog->user->last_name }}</p>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <div class="xy-end ">
                                    <img src="{{ asset('assets/images/nav-icon-2.png') }}" alt="img">
                                    <p class="date ms-2">{{ $blog->created_at->format('j F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($myBlog != null && $blog->user->id == auth()->id())
                    <div class="editbtnsWrap">
                        <button class="editBtn xy-center mb-2" href="#editBlogModal" data-bs-toggle="modal" id="editBlog" data-id="{{$blog->id}}">
                            <img  src="{{asset('assets/images/edit-icon-1.png')}}" alt="">
                        </button>
                        <button class="editBtn dtlBtn xy-center" href="#Deletemodal" data-bs-toggle="modal" data-id="{{$blog->id}}">
                            <img  src="{{asset('assets/images/edit-icon-2.png')}}" alt="">
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @else
            <p class="title">Blog not found.</p>
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

<!-- Edit Blog Modal Start-->
<div class="modal fade genModal" id="editBlogModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="headingMain text-center pt-4 pb-3">Edit Blog</p>
                <form class="paymentForm row" id="edit_blog_form" enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="uploadBox mb-3">
                            <label id="wrapper" for="fileUpload2" class="xy-center">
                                <img src="{{asset('assets/images/uploadIcon.png')}}" alt="img">
                                <p class="pt-2">Upload Image</p>
                                <input id="fileUpload2" name="blog_image" class="d-none" type="file" accept="image/gif, image/jpeg, image/png">
                            </label>

                        </div>
                        <input type="hidden" name="id" id="editBlogId" value="">
                        <div id="image-holder2" class="pb-2">

                        </div>
                    </div>
                    @csrf
                    <div class="col-12">
                        <div class="form-group logInput mb-3">

                            <select id="edit_category_id" name="category_id" class="input1 ps-4">
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
                            <select class="input1 ps-4" id="edit_sub_category_id" name="sub_category_id">
                                <option selected disabled>--</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group logInput mb-3">
                            <textarea class="textarea1 input1 ps-4 pt-3" id="edit_description" name="description" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="image-container">
                        <img id="image_src" src="" class="thumb-image">
                    </div>
                    <div class="col-12">
                        <button class="genBtn type2" id="edit_blog" type="button">Edit</button>
                    </div>
                </form>
                <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
<!--Edit Blog Modal End-->

<!--Delete Modal Start-->
<div class="modal fade genModal" id="Deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <form class="genForm row">
                    <div class="col-12">
                        <div class="row mb-3">
                            <div class="col-12">
                                <p class="headingMain text-center pb-3">Do you want to delete this?</p>
                            </div>
                            <div class="col-lg-2 col-md-2"></div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">

                            </div>
                            <div class="col-lg-2 col-md-2"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="genBtn type2" id="confirm_delete" type="button">Delete</button>

                    </div>
                </form>
                <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
<!--Delet Modal End-->

@endsection
@push('scripts')
<script src="{{ asset('assets/js/custom/user/user.js') }}"></script>
<script>
    $(document).ready(() => {
        var blogs =  @json($blogs); 
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
                    } else {
                        not(response.message, "error");
                    }
                },
            });
        });

        var blog_id = '';
        $(document).on('click', '#edit_blog', function() {
            var category_id = $('#edit_category_id').val();
            var sub_category_id = $('#edit_sub_category_id').val();
            var description = $('#edit_description').val();

            var image = $("[name='blog_image']")

            if (!category_id) {
                not('Please select category', 'error');
                return;
            } else if (!sub_category_id) {
                not('Please select sub category', 'error');
                return;
            } else if (!description) {
                not('Description field can not be empty', 'error');
                return;
            }

            var form = document.getElementById("edit_blog_form");

            $.ajax({
                type: "POST",
                url: baseUrl + "/edit-blog",
                data: new FormData(form),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.status > 0) {
                        location.reload();
                    } else {
                        not(response.message, "error");
                    }
                },
            });
        });


        $(document).on("change", "#category_id", function(e) {
            var id = $(this).val();
            loadSubCategoriesOptions(id, 'sub_category_id');
            return;
        });
        $(document).on("change", "#edit_category_id", function(e) {
            if (e.originalEvent) {
                var id = $(this).val();
                loadSubCategoriesOptions(id, 'edit_sub_category_id');
            }
        });

        $(document).on("click", "#editBlog", function() {
            id = +$(this).attr('data-id')
            var blog = blogs.find(blog => blog.id === id)
            $("#image_src").attr("src", `${$('#baseUrl').val()}${blog.blog_image}`);
            $('#editBlogId').val(blog.id)

            loadSubCategoriesOptions(blog.category_id, 'edit_sub_category_id', blog.sub_category_id);
            $('#edit_description').val(blog.description)
            $("#edit_category_id").val(blog.category_id).change();
            return;
        });

        var mainDiv = "";
        $(document).on("click", ".dtlBtn", function() {
            mainDiv = $(this).parentsUntil(".blogRow")
            blog_id = +$(this).attr('data-id')
        });


        $(document).on("click", ".closeModal", function() {
            blog_id = ''
        });

        $(document).on("click", "#confirm_delete", function() {
            $.get(
                baseUrl + "/delete-blog/" + blog_id,
                function(response) {
                    if (response.status > 0) {
                        location.reload();
                    }
                },
                "json"
            );
        });

        //sub_category_id is optional if you want to select the sub category in the html
        function loadSubCategoriesOptions(category_id, where_to_append_id, sub_category_id) {
            return $.get(
                baseUrl + "/get-sub-categories/" + category_id,
                function(response) {
                    var options =
                        '<option value="" selected disabled>-- Sub Category --</option>';
                    if (response.length > 0) {
                        $.each(response, function(index, data) {
                            var selected = (data.id === sub_category_id) ? 'selected' : ''
                            options +=
                                '<option value="' +
                                data.id +
                                '"  ' + selected + ' >' +
                                data.title +
                                "</option>";
                        });
                    }
                    $(`#${where_to_append_id}`).html(options);
                },
                "json"
            );
        }
    });
</script
@endpush
