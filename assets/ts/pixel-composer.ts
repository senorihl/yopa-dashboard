import JSONEditor from 'jsoneditor';
import {EventEmitter} from "events";
import LocaleCode from 'locale-code';
import 'jsoneditor/dist/jsoneditor.min.css';

declare global {
    interface Window {
        breadcrumbRemove: (removableId) => void;
        yopa?: any | EventEmitter;
        onYopaLoaded: (any) => void;
    }
}

const form = document.getElementById('pixel-composer');

const fields = {
    result: document.getElementById('result') as HTMLInputElement,
    type: document.getElementById('pixel_type') as HTMLSelectElement,
    action: document.getElementById('pixel_action') as HTMLInputElement,
    origin: document.getElementById('pixel_origin') as HTMLInputElement,
    locale: document.getElementById('pixel_locale') as HTMLInputElement,
    custom: document.getElementById('pixel_custom') as HTMLInputElement,
    custom_editor: document.getElementById('pixel_custom_editor') as HTMLDivElement,
};

const breadcrumb = {
    index: 1,
    more: document.getElementById('add-breadcrumb-element'),
    holder: null,
    prototype: null,
};

breadcrumb.holder = document.getElementById(breadcrumb.more.getAttribute('for') + 'holder');
breadcrumb.prototype = breadcrumb.more.getAttribute('data-prototype');

breadcrumb.more.addEventListener('click', function () {
    breadcrumb.holder.insertAdjacentHTML('beforeend', breadcrumb.prototype.replace(/__name__/gmi, breadcrumb.index));
    breadcrumb.index++
});

window.breadcrumbRemove = function (removableId) {
    document.getElementById(removableId).parentElement.remove();
};

const updatePixel = () => {
    const breadcrumbElements = document.querySelectorAll('[id^="pixel_breadcrumb_"]') as NodeListOf<HTMLInputElement>;
    const breadcrumb = [];
    const wrapper: any = {};
    const opts: any = {
        ...JSON.parse(fields.custom.value || '{}'),
        action: fields.action.value,
    };

    for (let i = 0 ; i < breadcrumbElements.length; i++) {
        if (breadcrumbElements[i].value.trim() !== '') {
            breadcrumb.push(breadcrumbElements[i].value);
        }

    }

    if (breadcrumb.length > 0) {
        opts.breadcrumb = breadcrumb;
    }

    if (fields.origin.value.trim() !== '') {
        wrapper.or = fields.origin.value.trim();
    }

    if (fields.locale.value.trim() !== '' && LocaleCode.validate(fields.locale.value.trim())) {
        wrapper.l = fields.locale.value.trim();
    }

    let method;
    const args = [];

    switch (fields.type.value) {
        case 'page': method = window.yopa.page; break;
        case 'click': method = window.yopa.click; break;
        case 'mailing': method = window.yopa.mailing; break;
    }

    args.push(fields.action.value);
    args.push({...opts, ...customEditor.get()});
    args.push(wrapper);
    window.yopa.disable = true;
    window.yopa.once('pixel', (pixelUrl, ...args) => {
        console.log(args);
        fields.result.value = `${window.location.protocol}${pixelUrl}`;
    });
    method.apply(window.yopa, args);
};

const customEditor = new JSONEditor(fields.custom_editor, {
    onChangeJSON: (data) => {
        fields.custom.value = JSON.stringify(data);
        updatePixel();
    },
    onValidate: function (json) {
        const errors = [];

        if (json && json.action) {
            errors.push({
                path: ['action'],
                message: `Action must be defined in the upper scope, actually: ${fields.action.value}`
            });
        }

        return errors;
    }
}, JSON.parse(fields.custom.value));

window.yopa.onLoaded(() => {
    form.addEventListener('change',updatePixel);
    form.addEventListener('keyup',updatePixel);
});

