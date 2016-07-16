export var stack_bottomright = { "dir1": "up", "dir2": "left", "firstpos1": 25, "firstpos2": 25 };

export function show_stack_success(msg, response) {
    var opts = {
        title: '',
        text: '',
        addclass: "stack-bottomright",
        stack: stack_bottomright,
        hide: true,
        delay: 5000,
        closer: true

    }
    if (msg === undefined) {
        opts.title = "Over Here";
        opts.text = "Everything worked.";
        opts.type = "success";
        opts.addclass = "stack-bottomright";
        opts.stack = stack_bottomright
    } else {
        opts.title = msg;
        opts.text = 'Success!';
        opts.type = "success";
    }
    new PNotify(opts);
}

export function show_stack_error(msg, response) {

    var opts = {
        title: '',
        text: '',
        addclass: "stack-bottomright",
        stack: stack_bottomright,
        hide: true,
        delay: 5000,
        closer: true
    }
    if (msg === undefined) {
        opts.title = "Failed action";
        opts.text = "Something broke.";
        opts.type = "error";
        opts.addclass = "stack-bottomright";
        opts.stack = stack_bottomright
    } else {
        opts.title = msg;
        opts.text = response.data.error.message;
        opts.type = "error";
    }
    new PNotify(opts);
}

export function show_stack_info(msg, response) {

    var opts = {
        title: '',
        text: '',
        addclass: "stack-bottomright",
        stack: stack_bottomright,
        hide: true,
        delay: 5000,
        closer: true
    }
    if (msg === undefined) {
        opts.title = "Notice me";
        opts.text = "All in order.";
        opts.type = "info";
        opts.addclass = "stack-bottomright";
        opts.stack = stack_bottomright
    } else {
        opts.title = msg;
        opts.text = 'Everything in order';
        opts.type = "info"
    }
    new PNotify(opts);
}



PNotify.prototype.options.styling = "fontawesome";
