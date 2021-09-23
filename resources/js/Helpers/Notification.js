class Notification {
    success() {
        new Noty({
            type: "success",
            layout: "topRight",
            timeout: 3000,
            text: 'successfully Done',

        }).show();
    }
    Alert() {
        new Noty({
            type: "alert",
            layout: "topRight",
            timeout: 3000,
            text: 'Are you Sure ?',

        }).show();
    }
    error() {
        new Noty({
            type: "alert",
            layout: "topRight",
            timeout: 3000,
            text: 'Something went to Wrnong',

        }).show();
    }
    warning() {
        new Noty({
            type: "warning",
            layout: "topRight",
            timeout: 3000,
            text: 'Opps Something going to be Wrong ?',

        }).show();
    }
}
export default Notification = new Notification();