/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
import { ClassicEditor } from '@ckeditor/ckeditor5-editor-classic';
import { Alignment } from '@ckeditor/ckeditor5-alignment';
import { Autoformat } from '@ckeditor/ckeditor5-autoformat';
import { Bold, Italic } from '@ckeditor/ckeditor5-basic-styles';
import { BlockQuote } from '@ckeditor/ckeditor5-block-quote';
import type { EditorConfig } from '@ckeditor/ckeditor5-core';
import { Essentials } from '@ckeditor/ckeditor5-essentials';
import { FontColor, FontSize } from '@ckeditor/ckeditor5-font';
import { Heading } from '@ckeditor/ckeditor5-heading';
import { Image, ImageCaption, ImageResize, ImageStyle, ImageToolbar, ImageUpload } from '@ckeditor/ckeditor5-image';
import { Indent } from '@ckeditor/ckeditor5-indent';
import { Link, LinkImage } from '@ckeditor/ckeditor5-link';
import { List } from '@ckeditor/ckeditor5-list';
import { MediaEmbed, MediaEmbedToolbar } from '@ckeditor/ckeditor5-media-embed';
import { RemoveFormat } from '@ckeditor/ckeditor5-remove-format';
import { ShowBlocks } from '@ckeditor/ckeditor5-show-blocks';
import { Style } from '@ckeditor/ckeditor5-style';
import { Table, TableCellProperties, TableColumnResize, TableProperties, TableToolbar } from '@ckeditor/ckeditor5-table';
import UploadedImageAttributes from './uploadedImageAttributes';
declare class Editor extends ClassicEditor {
    static builtinPlugins: (typeof UploadedImageAttributes | typeof Alignment | typeof Autoformat | typeof Bold | typeof Italic | typeof BlockQuote | typeof Essentials | typeof FontColor | typeof FontSize | typeof Heading | typeof Image | typeof ImageCaption | typeof ImageResize | typeof ImageStyle | typeof ImageToolbar | typeof ImageUpload | typeof Indent | typeof Link | typeof LinkImage | typeof List | typeof MediaEmbed | typeof MediaEmbedToolbar | typeof RemoveFormat | typeof ShowBlocks | typeof Style | typeof Table | typeof TableCellProperties | typeof TableColumnResize | typeof TableProperties | typeof TableToolbar)[];
    static defaultConfig: EditorConfig;
}
export default Editor;
