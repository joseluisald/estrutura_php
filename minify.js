const fs = require('fs');
const path = require('path');
const sass = require('node-sass');
const { minify } = require("terser");
const glob = require('glob-all');
const CleanCSS = require('clean-css');

function compileThemesCss(theme)
{
    const themesDir = path.join(__dirname, 'src');
    const themeDir = path.join(themesDir, theme);

    const assetsFolder = path.join(__dirname, 'assets', theme, 'css');
    const mapsDir = path.join(__dirname, 'assets', theme, 'css', 'maps');
    const compiledDir = path.join(__dirname, 'assets', theme, 'css');

    const sourceMapOptions = {
        sourceMapURL: path.join(mapsDir, `${theme}.map`),
        sourceMapFilename: path.join(compiledDir, `${theme}.min.css`),
        sourceMapBasepath: path.dirname(path.join(__dirname, '..')),
    };

    const compilerOptions = {
        file: path.join(themeDir, 'scss', 'styles.scss'),
        outFile: path.join(compiledDir, `${theme}.min.css`),
        outputStyle: 'compressed',
        sourceMap: path.join(mapsDir, `${theme}.map`),
        sourceMapContents: true,
        sourceMapOptions: sourceMapOptions,
        includePaths: [path.join(themesDir, theme, 'scss')],
    };

    sass.render(compilerOptions, (error, result) => {
        if (!error) {
            const css = result.css.toString();
            const sourceMap = result.map.toString();

            if (!fs.existsSync(assetsFolder)) {
                fs.mkdirSync(assetsFolder, { recursive: true });
            }
            if (!fs.existsSync(mapsDir)) {
                fs.mkdirSync(mapsDir, { recursive: true });
            }

            fs.writeFileSync(path.join(mapsDir, `${theme}.map`), sourceMap);
            fs.writeFileSync(path.join(compiledDir, `${theme}.min.css`), css);
            console.log(`SCSS for theme ${theme} compiled successfully!`);
        } else {
            console.error(`Error compiling SCSS for theme ${theme}:`, error);
        }
    });
}

function compileCoreCss()
{
    const themesDir = path.join(__dirname, 'src');
    const theme = 'common';
    const assetsFolder = path.join(__dirname, 'assets', theme, 'css');
    const cssPluginFolder = path.join(themesDir, theme, 'css');

    const cssPluginFiles = glob.sync([
        path.join(cssPluginFolder, '**', '*.css')
    ]);

    let cssPlugin = '';

    cssPluginFiles.forEach((file) => {
        cssPlugin += fs.readFileSync(file, 'utf-8');
    });

    if (!fs.existsSync(assetsFolder)) {
        fs.mkdirSync(assetsFolder, { recursive: true });
    }

    const minifiedCss = new CleanCSS().minify(cssPlugin).styles;
    fs.writeFileSync(path.join(assetsFolder, `${theme}.min.css`), minifiedCss);
    console.log(`Core CSS for theme ${theme} compiled successfully!`);
}

async function compileThemesJs(theme) {
    const themesDir = path.join(__dirname, 'src');
    const themeDir = path.join(themesDir, theme);

    const assetsFolder = path.join(__dirname, 'assets', theme, 'js');
    const mapsDir = path.join(__dirname, 'assets', theme, 'js', 'maps');
    const jsPluginFolder = path.join(themeDir, 'js');

    const jqueryPath = path.join(jsPluginFolder, 'jquery', 'jquery.min.js');
    const momentPath = path.join(jsPluginFolder, 'moment', 'moment.min.js');

    const jsPluginFiles = glob.sync([
        path.join(jsPluginFolder, '**', '*.js')
    ]);

    let jsPlugin = '';

    if (fs.existsSync(jqueryPath)) {
        jsPlugin += fs.readFileSync(jqueryPath, 'utf-8');
    }
    if (fs.existsSync(momentPath)) {
        jsPlugin += fs.readFileSync(momentPath, 'utf-8');
    }

    jsPluginFiles.forEach((file) => {
        const fileName = path.basename(file);
        if (fileName !== 'jquery.min.js' && fileName !== 'moment.min.js') {
            jsPlugin += fs.readFileSync(file, 'utf-8');
        }
    });

    if (!fs.existsSync(assetsFolder)) {
        fs.mkdirSync(assetsFolder, {recursive: true});
    }
    if (!fs.existsSync(mapsDir)) {
        fs.mkdirSync(mapsDir, { recursive: true });
    }

    const minifiedJs = await minify(jsPlugin, {
        sourceMap: true
    });

    fs.writeFileSync(path.join(assetsFolder, `${theme}.min.js`), minifiedJs.code);
    fs.writeFileSync(path.join(mapsDir, `${theme}.map`), minifiedJs.map);
    console.log(`JS for theme ${theme} compiled successfully!`);
}

(async () =>
{
    try {
        const themesDir = path.join(__dirname, 'src');
        const themesCss = fs.readdirSync(themesDir).filter((theme) => theme !== '.' && theme !== '..' && theme !== 'common');
        const themesJs = fs.readdirSync(themesDir).filter((theme) => theme !== '.' && theme !== '..');

        compileCoreCss();

        for (const theme of themesCss) {
            compileThemesCss(theme);
        }

        for (const theme of themesJs) {
            await compileThemesJs(theme);
        }

    } catch (error) {
        console.error('An error occurred:', error);
    }
})();
