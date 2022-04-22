const elForm = "#formContest";
const onkeyup = true;
const rules = {
    name: {
        required: true,
        maxlength: 255,
    },
    date_start: {
        required: true,
    },
    register_deadline: {
        required: true,
    },
    description: {
        required: true,
    },
    start_register_time: {
        required: true,
    },
    end_register_time: {
        required: true,
    },
};
const messages = {
    name: {
        required: "Chưa nhập trường này !",
        maxlength: "Tối đa là 255 kí tự !",
    },
    description: {
        required: "Chưa nhập trường này !",
    },
    register_deadline: {
        required: "Chưa nhập trường này !",
        min: "Thời gian kết thúc không được lớn hơn thời gian bắt đầu !",
    },
    date_start: {
        required: "Chưa nhập trường này !",
        min: "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !",
        max: "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc !",
    },
    start_register_time: {
        required: "Chưa  nhập trường này !",
        min: "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !",
        max: "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc!",
    },
    end_register_time: {
        required: "Chưa nhập trường này !",
        min: "Thời gian kết thúc đăng kí phải lớn hơn thời gian hiện tại và thời gian đăng kí cuộc thi!",
        max: "Thời gian kết thúc đăng kí phải nhỏ hơn thời gian bắt đầu cuộc thi!",
    },
};
let getTimeToday = new Date().toJSON().slice(0, 19);
// $.validator.addMethod(
//     "checkToday",
//     function (value) {
//         if (value > getTimeToday) {
//             return true;
//         }
//     },
//     "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại !"
// );
// $('input[name=end_register_time]').on("keyup change", function () {
//     let val = $(this).val();
//     $.validator.addMethod(
//         "checkTime",
//         function (value) {
//             if (value > val) {
//                 return true;
//             }
//         },
//         "Vui  lòng nhập thời gian bắt đầu nhỏ hơn thời gian kết thúc !!"
//     );
// });