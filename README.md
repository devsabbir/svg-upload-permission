# SVG Upload Permission Plugin

A lightweight WordPress plugin that allows SVG file uploads securely with a settings page to enable or disable the feature.

## Features

- Enable or disable SVG uploads via a settings page.
- Basic security checks for SVG sanitization.
- Validates SVG structure to prevent malformed uploads.
- Ready for internationalization with `.pot` template.

## Installation

1. Download the plugin and extract the folder `svg-upload-permission`.
2. Upload the folder to `/wp-content/plugins/`.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

Navigate to **Settings → SVG Upload** to toggle SVG upload permissions.

## Security

This plugin performs the following checks:

- Prevents `<script>` tags and `onload` events in SVG files.
- Validates the SVG structure to avoid malformed uploads.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for improvements.

## Author

Sabbir Hossain (devsabbir)

## License

MIT License

---

MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

---

## Internationalization (i18n)

A `.pot` file is included for translation. To contribute a new language:

1. Use the `/languages/svg-upload-permission.pot` template.
2. Generate `.po` and `.mo` files with your translations.
3. Place them inside `/languages/` named as `svg-upload-permission-{locale}.mo`.
