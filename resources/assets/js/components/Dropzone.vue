<template>
    <div id="actions">
        <div class="row">
            <div class="col-lg-12">
                <!-- This is used as the file preview template -->
                <div>
                    <span class="preview"><img data-dz-thumbnail :src="model" id="eikona" height="250" class="img-responsive"/></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <button class="btn btn-warning btn-flat btn-block fileinput-button dz-clickable">
                    <i class="fa fa-edit"></i>
                    <span>Update Image</span>
                </button>
            </div>
        </div>
    </div>


    <div class="table table-striped files" id="previews">

        <div id="template" class="file-row">
            <!-- This is used as the file preview template -->
            <div>
                <span class="preview"><img data-dz-thumbnail /></span>
            </div>
            <div>
                <p class="name" data-dz-name></p>
                <strong class="error text-danger" data-dz-errormessage></strong>
            </div>
            <div>
                <p class="size" data-dz-size></p>
                <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
            </div>
            <div>
                <button class="btn btn-primary start">
                    <i class="fa fa-upload"></i>
                    <span>Start</span>
                </button>
                <button data-dz-remove class="btn btn-warning cancel">
                    <i class="fa fa-remove"></i>
                    <span>Cancel</span>
                </button>
            </div>
        </div>

    </div>
</template>
<script>
    import Dropzone from 'dropzone'
    import Vue from 'vue'

    export default{
        props: {
            model: {required: true},
            action: {required: true},
        },
        ready () {
            let component = this

            let previewNode = document.querySelector("#template");
            previewNode.id = "";
            let previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);

            let myDropzone = new Dropzone(document.getElementById('actions'), { // Make the whole body a dropzone
                url: this.action, // Set the url
                thumbnailWidth: 400,
                thumbnailHeight: 250,
                parallelUploads: 20,
                previewTemplate: previewTemplate,
                autoQueue: false, // Make sure the files aren't queued until manually added
                previewsContainer: "#previews", // Define the container to display the previews
                clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
            });

            myDropzone.on("addedfile", function(file) {
                // hide actions
                document.getElementById('actions').style.display = "none";
                // Hookup the start button
                file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };

                //set cancel
                document.querySelector("#previews .cancel").onclick = function() {
                    // show actions
                    document.getElementById('actions').style.display = "block";
                    myDropzone.removeAllFiles(true);
                };
            });

            // Events regarding update
            myDropzone.on("sending", function(file) {
                // Show the total progress bar when upload starts
                document.querySelector("#total-progress").style.opacity = "1";
                // And disable the start button
                file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
            });

            myDropzone.on("success", function(response) {
                // update image src
                let imageSrc = JSON.parse(response.xhr.response).image
                document.getElementById('eikona').setAttribute('src', imageSrc)
                // show actions
                document.getElementById('actions').style.display = "block";
                // hide previes
                document.getElementById('previews').style.display = "none";

                myDropzone.removeAllFiles(true);

                console.log(component, imageSrc)
                // update model with the new image
                Vue.set(component, 'model', imageSrc)

                console.log(component, component.model)

            });
        }
    }
</script>
<style>
</style>
