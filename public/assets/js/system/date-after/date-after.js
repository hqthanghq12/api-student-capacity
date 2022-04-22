function dateAfter(begin, end, start_time, end_time) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;
    $(this.begin).prop("min", function () {
        return getTimeToday;
    });
    $(this.end).prop("min", function () {
        return getTimeToday;
    });
    $(this.start_time).prop("min", function () {
        return getTimeToday;
    });
    $(this.end_time).prop("min", function () {
        return getTimeToday;
    });
    $(this.begin).on("keyup change", function () {
        let val = $(this).val();
        $(that.end).prop("min", function () {
            return val;
        });
        $(that.start_time).prop("max", function () {
            return val;
        });
        $(that.end_time).prop("max", function () {
            return val;
        });
    });
    $(this.end).on("keyup change", function () {
        let val = $(this).val();
        $(that.begin).prop("max", function () {
            return val;
        });
    });
    $(this.start_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.end_time).prop("min", function () {
            return val;
        });
    });
    $(this.end_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.start_time).prop("max", function () {
            return val;
        });
    });
}
function dateAfterEdit(begin, end, start_time, end_time) {
    let getTimeToday = new Date().toJSON().slice(0, 19);
    let that = this;
    $(end).prop("min", function () {
        return getTimeToday;
    });
    $(begin).prop("min", function () {
        return getTimeToday;
    });
    $(begin).prop("max", function () {
        return $(end).val();
    });
    $(start_time).prop("min", function () {
        return getTimeToday;
    });
    $(start_time).prop("max", function () {
        return $(end_time).val();
    });
    $(end_time).prop("min", function () {
        return getTimeToday;
    });
    $(end_time).prop("max", function () {
        return $(begin).val();
    });

    $(this.begin).on("keyup change", function () {
        let val = $(this).val();
        $(that.end).prop("min", function () {
            return val;
        });
        $(that.start_time).prop("max", function () {
            return val;
        });
        $(that.end_time).prop("max", function () {
            return val;
        });
    });
    $(this.end).on("keyup change", function () {
        let val = $(this).val();
        $(that.begin).prop("max", function () {
            return val;
        });
    });
    $(this.start_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.end_time).prop("min", function () {
            return val;
        });
    });
    $(this.end_time).on("keyup change", function () {
        let val = $(this).val();
        $(that.start_time).prop("max", function () {
            return val;
        });
    });
}