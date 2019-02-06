import JSONEditor from 'jsoneditor';
import 'jsoneditor/dist/jsoneditor.min.css';

declare global {
    interface Window {
        breadcrumbRemove: (removableId) => void;
    }
}

const form = document.getElementById('pixel-composer');

const fields = {
    result: document.getElementById('result') as HTMLInputElement,
    type: document.getElementById('pixel_type') as HTMLSelectElement,
    action: document.getElementById('pixel_action') as HTMLInputElement,
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

    fields.result.value = `//${SERVICE_URL || window.location.host}/pixel.png?yt=${fields.type.value}&yc=${encodeURIComponent(JSON.stringify(opts))}`;
};

new JSONEditor(fields.custom_editor, {
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

form.addEventListener('change',updatePixel);
form.addEventListener('keyup',updatePixel);
document.addEventListener('DOMContentLoaded', updatePixel);
