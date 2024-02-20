// import UploadedImageAttributes from "../ckeditor5-40.1.0/src/uploadedImageAttributes";
// import CKEditor from '../ckeditor5-40.1.0'


function CKEditorCreate(el, uploadUrl) {
    // let editor = CKEditor
    //     .create(el, {
    //         // plugins: [
    //         // UploadedImageAttributes
    //         // ],
    //         language: 'pl',
    //         simpleUpload: {
    //             // The URL that the images are uploaded to.
    //             uploadUrl: uploadUrl,
    //
    //             // Enable the XMLHttpRequest.withCredentials property.
    //             withCredentials: true,
    //
    //             // Headers sent along with the XMLHttpRequest to the upload server.
    //             // headers: {
    //             //     'X-CSRF-TOKEN': 'CSRF-Token',
    //             //     Authorization: 'Bearer <JSON Web Token>'
    //             // }
    //         }
    //     })
    //     .catch(error => {
    //         console.error(error);
    //     });

    import('../ckeditor5-40.1.0/build/ckeditor').then(async CKEditor => {

        let editor = await CKEditor.default
            .create(el, {
                // plugins: [
                    // UploadedImageAttributes
                // ],
                language: 'pl',
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: uploadUrl,

                    // Enable the XMLHttpRequest.withCredentials property.
                    withCredentials: true,

                    // Headers sent along with the XMLHttpRequest to the upload server.
                    // headers: {
                    //     'X-CSRF-TOKEN': 'CSRF-Token',
                    //     Authorization: 'Bearer <JSON Web Token>'
                    // }
                }
            })
            .catch(error => {
                console.error(error);
            });
    })
}

window.CKEditorCreate = CKEditorCreate