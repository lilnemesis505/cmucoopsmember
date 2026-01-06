<script setup>
import { ref, computed } from 'vue';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import { 
    ClassicEditor, 
    Essentials, Paragraph, Bold, Italic, Font, List, Link as CkLink, 
    BlockQuote, Heading, Table, TableToolbar, Undo,
    Alignment, Image, ImageCaption, ImageStyle, ImageToolbar, ImageUpload, Base64UploadAdapter,
    Indent, IndentBlock, HorizontalLine, MediaEmbed, SourceEditing, RemoveFormat
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

// รับค่า v-model จากหน้าหลัก
const props = defineProps({
    modelValue: String,
});

const emit = defineEmits(['update:modelValue']);

// ส่งค่ากลับเมื่อมีการแก้ไขข้อมูล
const editorData = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

const editor = ClassicEditor;

// --- รวม Config ไว้ที่จุดเดียว ---
const editorConfig = {
    licenseKey: 'GPL',
    plugins: [
        Essentials, Paragraph, Heading, Bold, Italic, Font, List, CkLink, 
        BlockQuote, Table, TableToolbar, Undo,
        Alignment, Image, ImageCaption, ImageStyle, ImageToolbar, ImageUpload, Base64UploadAdapter,
        Indent, IndentBlock, HorizontalLine, MediaEmbed, SourceEditing, RemoveFormat
    ],
    toolbar: {
        items: [
            'undo', 'redo', 
            '|', 'sourceEditing', 
            '|', 'heading', 
            '|', 'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor',
            '|', 'bold', 'italic', 'removeFormat',
            '|', 'alignment', 'bulletedList', 'numberedList', 'outdent', 'indent',
            '|', 'link', 'insertTable', 'uploadImage', 'mediaEmbed', 'blockQuote', 'horizontalLine'
        ],
        shouldNotGroupWhenFull: true 
    },
    // ตั้งค่าฟอนต์ (รวมไว้ที่นี่ทีเดียว)
    fontFamily: {
        options: [
            'default',
            'Sarabun, sans-serif',
            'Prompt, sans-serif',
            'Kanit, sans-serif',
            'Mitr, sans-serif',
            'Chakra Petch, sans-serif',
            'Arial, Helvetica, sans-serif',
            'Kodchasan, sans-serif'
        ],
        supportAllValues: true
    },
    image: {
        toolbar: [
            'imageTextAlternative', '|',
            'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
        ]
    },
    table: {
        contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties' ]
    }
};
</script>

<template>
    <div class="rich-text-editor-wrapper">
        <component :is="'style'">
            @import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;600&family=Kanit:wght@300;400;600&family=Mitr:wght@300;400;600&family=Prompt:wght@300;400;600&family=Sarabun:wght@300;400;600&family=Kodchasan:wght@300;400;600display=swap');
        </component>

        <Ckeditor 
            :editor="editor" 
            v-model="editorData" 
            :config="editorConfig" 
        />
    </div>
</template>

<style>
/* Style เฉพาะของ CKEditor */
.ck-editor__editable {
    min-height: 350px;
    padding: 1rem !important;
}
.ck.ck-toolbar {
    border-top-left-radius: 0.5rem !important;
    border-top-right-radius: 0.5rem !important;
    border-color: #cbd5e1 !important;
}
.ck.ck-content {
    border-bottom-left-radius: 0.5rem !important;
    border-bottom-right-radius: 0.5rem !important;
    border-color: #cbd5e1 !important;
}
</style>