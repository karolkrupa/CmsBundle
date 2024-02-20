import {Plugin} from "@ckeditor/ckeditor5-core";

export default class UploadedImageAttributes extends Plugin {
    // static get requires(): readonly [typeof ImageCaptionEditing, typeof ImageCaptionUI];

    init() {
        let editor = this.editor

        editor.model.schema.extend('imageBlock', {allowAttributes: 'dataFileId'});

        editor.conversion.for('upcast').attributeToAttribute({
            view: 'data-file-id',
            model: 'dataFileId'
        });

        editor.conversion.for('downcast').add(dispatcher => {
            dispatcher.on('attribute:dataFileId:imageBlock', (evt, data, conversionApi) => {
                if (!conversionApi.consumable.consume(data.item, evt.name)) {
                    return;
                }

                const viewWriter = conversionApi.writer;
                const figure = conversionApi.mapper.toViewElement(data.item);
                const img = figure.getChild(0);

                if (data.attributeNewValue !== null) {
                    viewWriter.setAttribute('data-file-id', data.attributeNewValue, img);
                } else {
                    viewWriter.removeAttribute('data-file-id', img);
                }
            });
        });

        const imageUploadEditing = editor.plugins.get('ImageUploadEditing');

        editor.plugins.get('ImageUploadEditing').on('uploadComplete', (evt, {data, imageElement}) => {
            editor.model.change(writer => {
                writer.setAttribute('dataFileId', data.id, imageElement);
            });
        });
    }

    // afterInit() {
    //     console.log('AFTER INIT')
    //
    //
    // }


}