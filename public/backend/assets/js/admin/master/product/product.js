$(document).ready(function () {
    ImgUpload();
});
$("#category").on("change", function () {
    getSubCategory();
});

$("#collection").on("change", function () {
    getSubCollection();
});
$("#project").on("change", function () {
    getCategory();
});
//get subcategory 
function getSubCategory() {
    var category_id = $("#category").val();
    $.ajax({
        url: 'getsubcategory',
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            category_id: category_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#subcategory").html(
                '<option disabled selected value="">Select Sub Category Name</option>'
            );
            $.each(result.subcategory, function (key, value) {
                $("#subcategory").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.sub_category_name +
                    "</option>"
                );
            });
        }
    });
}

//get subcollection
function getSubCollection() {
    var collection_id = $("#collection").val();
    $.ajax({
        url: 'getsubcategory',
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            collection_id: collection_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#sub_collection").html(
                '<option disabled selected value="">Select Sub Collection Name</option>'
            );
            $.each(result.subcollection, function (key, value) {
                $("#sub_collection").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.sub_collection_name +
                    "</option>"
                );
            });
        }
    });
}
// get category
function getCategory() {
    var project_id = $("#project").val();
    $.ajax({
        url: 'getsubcategory',
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            project_id: project_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#category").html(
                '<option disabled selected value="">Select Category Name</option>'
            );
            $.each(result.category, function (key, value) {
                $("#category").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.category_name +
                    "</option>"
                );
            });
        }
    });
}

// imgPreview
const chooseFile = document.getElementById("product_image");
const imgPreview = document.getElementById("img-preview");

chooseFile.addEventListener("change", function () {
    getImgData();
});

function getImgData() {
    const files = chooseFile.files[0];
    if (files) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(files);
        fileReader.addEventListener("load", function () {
            imgPreview.style.display = "block";
            imgPreview.innerHTML = '<a href="' + this.result +
                '" data-lightbox="uploaded-image-1" data-title="Selected Image"><img class="img-fluid ml-2" width="40" height="40" src="' +
                this.result + '" /></a>';
        });
    }
}

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $(".upload__inputfile").each(function () {
        $(this).on("change", function (e) {
            imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
            var maxLength = $(this).attr("data-max_length");

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {
                if (!f.type.match("image.*")) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false;
                } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html =
                                "<div class='upload__img-box'><div style='background-image: url(" +
                                e.target.result +
                                ")' data-number='" +
                                $(".upload__img-close").length +
                                "' data-file='" +
                                f.name +
                                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        };
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    $("body").on("click", ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
    });
}
