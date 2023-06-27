const colorInput = document.getElementById('Color');
const colorHexInput = document.getElementById('ColorHex');

colorInput.addEventListener('input', function () {
    const selectedColor = colorInput.value;
    let convertedColor = selectedColor;

    if (selectedColor.startsWith('hsl')) {
        convertedColor = hslToHex(selectedColor);
    } else if (selectedColor.startsWith('rgb')) {
        convertedColor = rgbToHex(selectedColor);
    }

    colorHexInput.value = convertedColor;
});

function hslToHex(hsl) {
    // Obtener los valores HSL
    const matches = hsl.match(/^hsl\((\d+),\s*(\d+%),\s*(\d+)%\)$/);

    if (matches) {
        // Convertir los valores HSL a RGB
        const h = parseInt(matches[1]);
        const s = parseInt(matches[2]) / 100;
        const l = parseInt(matches[3]) / 100;
        const rgb = hslToRgb(h, s, l);

        // Convertir los valores RGB a hexadecimal
        const r = rgb[0].toString(16).padStart(2, '0');
        const g = rgb[1].toString(16).padStart(2, '0');
        const b = rgb[2].toString(16).padStart(2, '0');

        // Retornar el color en formato hexadecimal
        return `#${r}${g}${b}`;
    }

    // Retornar el color original si no se puede convertir
    return hsl;
}

function hslToRgb(h, s, l) {
    let r, g, b;

    if (s === 0) {
        r = g = b = l;
    } else {
        const hue2rgb = function hue2rgb(p, q, t) {
            if (t < 0) t += 1;
            if (t > 1) t -= 1;
            if (t < 1 / 6) return p + (q - p) * 6 * t;
            if (t < 1 / 2) return q;
            if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
            return p;
        };

        const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        const p = 2 * l - q;
        r = Math.round(hue2rgb(p, q, h + 1 / 3) * 255);
        g = Math.round(hue2rgb(p, q, h) * 255);
        b = Math.round(hue2rgb(p, q, h - 1 / 3) * 255);
    }

    return [r, g, b];
}

function rgbToHex(rgb) {
    // Obtener los valores RGB
    const matches = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

    if (matches) {
        // Convertir los valores RGB a hexadecimal
        const r = parseInt(matches[1]).toString(16).padStart(2, '0');
        const g = parseInt(matches[2]).toString(16).padStart(2, '0');
        const b = parseInt(matches[3]).toString(16).padStart(2, '0');

        // Retornar el color en formato hexadecimal
        return `#${r}${g}${b}`;
    }

    // Retornar el color original si no se puede convertir
    return rgb;
}

document.getElementById('categoriaABM').addEventListener('submit', function () {
    // Actualizar el valor del campo oculto con el color en formato hexadecimal
    const selectedColor = colorInput.value;
    let convertedColor = selectedColor;

    if (selectedColor.startsWith('hsl')) {
        convertedColor = hslToHex(selectedColor);
    } else if (selectedColor.startsWith('rgb')) {
        convertedColor = rgbToHex(selectedColor);
    }

    colorHexInput.value = convertedColor;
});