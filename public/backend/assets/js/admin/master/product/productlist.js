var baseurl = window.location.origin;
$(document).ready(function () {
    //product list
    productList();
    // ImgUpload();
});

$("#subcategoryfilter,#categoryfilter").change(function () {
    productList();
});

function productList() {
    var category_id =
        $("#categoryfilter option:selected").val() == undefined
            ? 0
            : $("#categoryfilter option:selected").val();
    var sub_category_id =
        $("#subcategoryfilter option:selected").val() == undefined
            ? 0
            : $("#subcategoryfilter option:selected").val();

    //Get type from url to the dataTable
    var type = "";
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("type")) {
        type = urlParams.get("type");
    }
    $("#tableProduct").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "getproductsdata/" + type,
            data: function (product) {
                product.category_id = category_id;
                product.sub_category_id = sub_category_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            {
                data: "id",
            },
            {
                data: "product_image",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return (
                        '<a href="' +
                        baseurl +
                        "/upload/product/"+
                        row.product_image +
                        '" data-lightbox="image-' +
                        row.id +
                        '" data-title="Product Image"><img src="' +
                        baseurl +
                        "/upload/product/" +
                        row.product_image +
                        '" class="avatar" width="38" height="38"/></a>'
                    );
                },
            },
            {
                data: "product_unique_id",
            },
            {
                data: "product_name",
            },
            {
                data: "category_name",
            },
            {
                data: "sub_category_name",
            },
            {
                data: "color_name",
            },
            // {
            //     data: "zone_name",
            // },
            {
                data: "project_name",
            },
            {
                data: "qty",
            },
            {
                data: "weight",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkProduct${row.id}" 
                    onclick="doStatus(${row.id});" ${
                        data == 1 ? "checked" : ""
                    }>
                    <div class="state p-success">
                        <label></label>
                    </div>
                </div>`;
                },
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
}
$("#category").on("change", function () {
    getSubCategory();
});

$("#collection").on("change", function () {
    getSubCollection();
});

//get subcategory
function getSubCategory() {
    var category_id = $("#category").val();
    $.ajax({
        url: "getsubcategory",
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
        },
    });
}

//get subcollection
// function getSubCollection() {
//     var collection_id = $("#collection").val();
//     $.ajax({
//         url: "getsubcategory",
//         type: "GET",
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//         data: {
//             collection_id: collection_id,
//             _token: $('meta[name="csrf-token"]').attr("content"),
//         },
//         dataType: "json",
//         success: function (result) {
//             $("#sub_collection").html(
//                 '<option disabled selected value="">Select Sub Collection Name</option>'
//             );
//             $.each(result.subcollection, function (key, value) {
//                 $("#sub_collection").append(
//                     '<option value="' +
//                         value.id +
//                         '">' +
//                         value.sub_collection_name +
//                         "</option>"
//                 );
//             });
//         },
//     });
// }
// imgPreview
// const chooseFile = document.getElementById("product_image");
// const imgPreview = document.getElementById("img-preview");

// chooseFile.addEventListener("change", function () {
//     getImgData();
// });

// function getImgData() {
//     const files = chooseFile.files[0];
//     if (files) {
//         const fileReader = new FileReader();
//         fileReader.readAsDataURL(files);
//         fileReader.addEventListener("load", function () {
//             imgPreview.style.display = "block";
//             imgPreview.innerHTML =
//                 '<a href="' +
//                 this.result +
//                 '" data-lightbox="uploaded-image-1" data-title="Selected Image"><img class="img-fluid ml-2" width="40" height="40" src="' +
//                 this.result +
//                 '" /></a>';
//         });
//     }
// }

function doEdit(Id) {
    $("#productId").val(Id);
    getProductById(Id);
}

function getProductById(Id) {
    $.ajax({
        type: "GET",
        url: "getproduct/" + Id,
        dataType: "json",
        success: function (data) {
            $("#productUniqueId").val(data.product.product_unique_id);
            $("#product_unique_id").val(data.product.product_unique_id);
            $("#product_name").val(data.product.product_name);
            $("#productImage").val(data.product.product_image);
            $("#img").attr("src", baseurl + "/" + data.product.product_image);
            $("#imglink").attr(
                "href",
                baseurl + "/" + data.product.product_image
            );
            $("#product_image").removeAttr("required");
            // $("#product_price").val(data.product.product_price);
            // $("#designed_date").val(data.product.designed_date);
            // $("#design_updated_date").val(data.product.design_updated_date);
            $("#height").val(data.product.height);
            $("#weight").val(data.product.weight);
            // $("#depth").val(data.product.depth);
            // $("#density").val(data.product.density);
            $("#width").val(data.product.width);
            $("#product_carat").val(data.product.product_carat);
            setTimeout(function () {
                $("#product_color")
                    .val(data.product.color_id)
                    .trigger("change");
            }, 500);
            setTimeout(function () {
                $("#product_style")
                    .val(data.product.style_id)
                    .trigger("change");
            }, 700);
            setTimeout(function () {
                $("#product_finish")
                    .val(data.product.finish_id)
                    .trigger("change");
            }, 1000);
            // setTimeout(function () {
            //     $("#weight").val(data.product.weight_id).trigger("change");
            // }, 1000);
            // setTimeout(function () {
            //     $("#size").val(data.product.size_id);
            // }, 1500);
            // $("#finishing").val(data.product.finishing);
            setTimeout(function () {
                $("#project").val(data.product.project_id).trigger("change");
            }, 1500);
            // $("#base_product").val(data.product.base_product);
            setTimeout(function () {
                $("#category").val(data.product.category_id).trigger("change");
            }, 2000);
            setTimeout(function () {
                $("#subcategory")
                    .val(data.product.sub_category_id)
                    .trigger("change");
            }, 3000);
            // setTimeout(function () {
            //     $("#zone").val(data.product.zone_id).trigger("change");
            // }, 3500);
            // setTimeout(function () {
            //     $("#collection")
            //         .val(data.product.collection_id)
            //         .trigger("change");
            // }, 4000);
            // setTimeout(function () {
            //     $("#sub_collection")
            //         .val(data.product.sub_collection_id)
            //         .trigger("change");
            // }, 4500);
            $("#making_percent").val(data.product.making_percent);
            $("#moq").val(data.product.moq);
            // $("#hallmarking").val(data.product.hallmarking);
            $("#crwcolcode").val(data.product.crwcolcode);
            $("#crwsubcolcode").val(data.product.crwsubcolcode);
            setTimeout(function () {
                $("#gender").val(data.product.gender).trigger("change");
            }, 5000);
            $("#cwqty").val(data.product.cwqty);
            $("#qty").val(data.product.qty);
            setTimeout(function () {
                $("#unit").val(data.product.unit_id).trigger("change");
            }, 5500);
            // setTimeout(function () {
            //     $("#brand").val(data.product.brand_id).trigger("change");
            // }, 6000);
            setTimeout(function () {
                $("#metal").val(data.product.metal_type_id).trigger("change");
            }, 6500);

            // setTimeout(function () {
            //     $("#jewel").val(data.product.jewel_type_id).trigger("change");
            // }, 7000);
            // setTimeout(function () {
            //     $("#purity").val(data.product.purity_id).trigger("change");
            // }, 7500);
            // $("#shape").val(data.product.shape);
            // setTimeout(function () {
            //     $("#plating").val(data.product.plating_id);
            // }, 8000);
            $("#net_weight").val(data.product.net_weight);
            $("#keywordtags").val(data.product.keywordtags);
            $("#otherrate").val(data.product.otherrate);
            $(".upload__img-wrap").empty(); // Clear the container first
            // if (
            //     data.productmultipleimage &&
            //     data.productmultipleimage.length > 0
            // ) {
            //     $.each(data.productmultipleimage, function (index, img) {
            //         var html = `<div class='upload__img-box'>
            //             <div style='background-image: url(${img.product_images})' class='img-bg'>
            //                 <div class='upload__img-close' id='${img.id}' onclick='deleteimg(${img.id});'></div>
            //             </div>
            //         </div>`;
            //         $(".upload__img-wrap").append(html); // Append the HTML to the container
            //     });
            // }
        },
    });
}

function doStatus(id) {
    var status = $("#chkProduct" + id).is(":checked");
    confirmStatusChange(
        id,
        "productstatus/",
        "tableProduct",
        status == true ? 1 : 0,
        "chkProduct"
    );
}

function showDelete(id) {
    confirmDelete(id, "deleteproduct/", "tableProduct");
}

// function ImgUpload() {
//     var imgWrap = "";
//     var imgArray = [];

//     $(".upload__inputfile").each(function () {
//         $(this).on("change", function (e) {
//             imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
//             var maxLength = $(this).attr("data-max_length");

//             var files = e.target.files;
//             var filesArr = Array.prototype.slice.call(files);
//             var iterator = 0;
//             filesArr.forEach(function (f, index) {
//                 if (!f.type.match("image.*")) {
//                     return;
//                 }

//                 if (imgArray.length > maxLength) {
//                     return false;
//                 } else {
//                     var len = 0;
//                     for (var i = 0; i < imgArray.length; i++) {
//                         if (imgArray[i] !== undefined) {
//                             len++;
//                         }
//                     }
//                     if (len > maxLength) {
//                         return false;
//                     } else {
//                         imgArray.push(f);

//                         var reader = new FileReader();
//                         reader.onload = function (e) {
//                             var html =
//                                 "<div class='upload__img-box'><div style='background-image: url(" +
//                                 e.target.result +
//                                 ")' data-number='" +
//                                 $(".upload__img-close").length +
//                                 "' data-file='" +
//                                 f.name +
//                                 "' class='img-bg'><div class='upload__img-close'></div></div></div>";
//                             imgWrap.append(html);
//                             iterator++;
//                         };
//                         reader.readAsDataURL(f);
//                     }
//                 }
//             });
//         });
//     });

//     $("body").on("click", ".upload__img-close", function (e) {
//         var file = $(this).parent().data("file");
//         for (var i = 0; i < imgArray.length; i++) {
//             if (imgArray[i].name === file) {
//                 imgArray.splice(i, 1);
//                 break;
//             }
//         }
//         $(this).parent().parent().remove();
//     });
// }

// function deleteimg(id) {
//     $.ajax({
//         url: "deletemultipleimage/" + id,
//         type: "GET",
//         // headers: {
//         //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         // },
//         dataType: "json",
//         success: function (response) {
//             console.log(response);
//         },
//     });
// }
