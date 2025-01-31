import 'filepond/dist/filepond.min.css';
import * as FilePond from 'filepond';

window.FilePond = FilePond

// Locale
import pl from 'filepond/locale/pl-pl'

FilePond.setOptions(pl)

// Import the plugin code
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

// Register the plugin
FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);


// Preview plugin
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

FilePond.registerPlugin(FilePondPluginImagePreview);

// Import the plugin code
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';

// Import the plugin styles
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';

// Register the plugin
FilePond.registerPlugin(FilePondPluginFilePoster);

const DEFAULT_OPTIONS = {
    postUrl: null,
    loadUrl: null,
    files: [],
    multiple: false,
    allowReorder: false,
    allowRemove: true,
    allowReplace: true
}

window.createFilePond = function (element, filepondOptions = DEFAULT_OPTIONS) {
    if (!element) {
        return;
    }

    let form = element.parentElement
    while (form && !['form', 'body'].includes(form.nodeName.toLowerCase())) {
        form = form.parentElement

    }

    let pond = FilePond.create(element, {
        // stylePanelLayout: 'compact',
        // styleLoadIndicatorPosition: 'center bottom',
        // styleProgressIndicatorPosition: 'right bottom',
        // styleButtonRemoveItemPosition: 'left bottom',
        // styleButtonProcessItemPosition: 'right bottom',
        allowMultiple: filepondOptions.multiple,
        allowFileSizeValidation: true,
        maxFileSize: '{{ max_size }}',
        files: filepondOptions.files,
        allowReorder: filepondOptions.allowReorder,
        allowRemove: filepondOptions.allowRemove,
        allowReplace: filepondOptions.allowReplace,
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                // fieldName is the name of the input field
                // file is the actual file object to send
                const formData = new FormData();
                formData.append('file', file, file.name);

                const request = new XMLHttpRequest();
                request.open('POST', filepondOptions.postUrl);

                // Should call the progress method to update the progress to 100% before calling load
                // Setting computable to false switches the loading indicator to infinite mode
                request.upload.onprogress = (e) => {
                    progress(e.lengthComputable, e.loaded, e.total);
                };

                // Should call the load method when done and pass the returned server file id
                // this server file id is then used later on when reverting or restoring a file
                // so your server knows which file to return without exposing that info to the client
                request.onload = function () {
                    if (request.status >= 200 && request.status < 300) {
                        // the load method accepts either a string (id) or an object
                        load(request.responseText);
                    } else {
                        // Can call the error method if something is wrong, should exit after
                        error(request.responseText);
                    }
                };

                request.send(formData);

                // Should expose an abort method so the request can be cancelled
                return {
                    abort: () => {
                        // This function is entered if the user has tapped the cancel button
                        request.abort();

                        // Let FilePond know the request has been cancelled
                        abort();
                    },
                };
            },
            revert: null,
            restore: null,
            load: filepondOptions.loadUrl,
            fetch: null
        }
    })

    if (!form) {
        return;
    }

    if (form.nodeName.toLowerCase() === 'form') {
        let submits = form.querySelectorAll('[type="submit"]')

        pond.on('initfile', (file) => {
            if (file.origin !== 1) {
                return;
            }
            for (let submit of submits) {
                submit.setAttribute('disabled', '');
                submit.classList.add('opacity-50')
            }
        });

        pond.on('processfilestart', (e) => {
            for (let submit of submits) {
                submit.setAttribute('disabled', '');
                submit.classList.add('opacity-50')
            }
        });

        pond.on('processfiles', (e) => {
            for (let submit of submits) {
                submit.removeAttribute('disabled', '');
                submit.classList.remove('opacity-50')
            }
        });

        pond.on('processfile', (e) => {
            for (let submit of submits) {
                submit.removeAttribute('disabled', '');
                submit.classList.remove('opacity-50')
            }
        });

        pond.on('error', (e) => {
            for (let submit of submits) {
                submit.removeAttribute('disabled', '');
                submit.classList.remove('opacity-50')
            }
        });
    }
}