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

window.createFilePond = function (element, multiple, files, postUrl, loadUrl) {
    if(!element) {
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
        allowMultiple: multiple,
        allowFileSizeValidation: true,
        maxFileSize: '{{ max_size }}',
        files: files,
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                // fieldName is the name of the input field
                // file is the actual file object to send
                const formData = new FormData();
                formData.append('file', file, file.name);

                const request = new XMLHttpRequest();
                request.open('POST', postUrl);

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
            load: loadUrl,
            fetch: null
        }
    })

    if(!form) {
        return;
    }

    if (form.nodeName.toLowerCase() === 'form') {
        let submits = form.querySelectorAll('[type="submit"]')

        pond.on('initfile', (file) => {
            console.log('INIT FILE')
            if(file.origin !== 1) {
                return;
            }
            for (let submit of submits) {
                submit.setAttribute('disabled', '');
                submit.classList.add('opacity-50')
            }
        });

        pond.on('processfilestart', (e) => {
            console.log('PROCESS START')

            for (let submit of submits) {
                submit.setAttribute('disabled', '');
                submit.classList.add('opacity-50')
            }
        });

        pond.on('processfiles', (e) => {
            console.log('PROCESSED')
            for (let submit of submits) {
                submit.removeAttribute('disabled', '');
                submit.classList.remove('opacity-50')
            }
        });

        pond.on('processfile', (e) => {
            console.log('PROCESSED')
            for (let submit of submits) {
                submit.removeAttribute('disabled', '');
                submit.classList.remove('opacity-50')
            }
        });

        pond.on('error', (e) => {
            console.log('PROCESSED ERROR')
            for (let submit of submits) {
                submit.removeAttribute('disabled', '');
                submit.classList.remove('opacity-50')
            }
        });
    }
}