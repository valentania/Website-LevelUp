const fs = require('fs');
const path = require('path');

const cssReplacements = [
    // Variables
    { from: /--navy-dark:\s*#080C17;/g, to: '--navy-dark: #203627;' },
    { from: /--navy:\s*rgba\(0, 0, 0, 0\.3\);/g, to: '--navy: #EFEFEF;' },
    { from: /--navy-light:\s*rgba\(0, 0, 0, 0\.4\);/g, to: '--navy-light: #9DC4D5;' },
    { from: /--cream:\s*#F8FAFC;/g, to: '--cream: #EFEFEF;' },
    { from: /--yellow:\s*#CDF22B;/g, to: '--yellow: #E8FF40;' },
    { from: /--gold:\s*#1E45FB;/g, to: '--gold: #9DC4D5;' },
    { from: /--cream-dark:\s*#CBD5E1;/g, to: '--cream-dark: #203627;' },
    { from: /--glass-bg:\s*rgba\(0, 0, 0, 0\.15\);/g, to: '--glass-bg: #EFEFEF;' },
    { from: /--glass-border:\s*rgba\(205, 242, 43, 0\.15\);/g, to: '--glass-border: #9DC4D5;' },

    // Body & wrapper
    { from: /body\s*\{\s*font-family([^}]+)background:\s*#080C17;\s*color:\s*#F8FAFC;/g, to: 'body {\n    font-family$1background: #EFEFEF;\n    color: #203627;' },
    { from: /background:\s*#080C17;/g, to: 'background: #EFEFEF;' }, // Default content
    { from: /color:\s*#F8FAFC;/g, to: 'color: #203627;' }, // Default text

    // Glass Cards
    { from: /background:\s*rgba\(0, 0, 0, 0\.2\);\s*backdrop-filter:[^}]+border:\s*1px\s*solid\s*rgba\(248, 250, 252, 0\.12\);/g, to: 'background: #EFEFEF;\n    border: 1px solid #9DC4D5;' },
    { from: /background:\s*rgba\(248, 250, 252, 0\.06\);\s*backdrop-filter:[^}]+border:\s*1px\s*solid\s*rgba\(248, 250, 252, 0\.1\);/g, to: 'background: #EFEFEF;\n    border: 1px solid #9DC4D5;' },
    { from: /background:\s*rgba\(0, 0, 0, 0\.3\);\s*backdrop-filter:[^}]+border:\s*1px\s*solid\s*rgba\(248, 250, 252, 0\.1\);/g, to: 'background: #EFEFEF;\n    border: 1px solid #9DC4D5;' },
    { from: /border-color:\s*rgba\(248, 250, 252, 0\.3\);/g, to: 'border-color: #E8FF40;' },
    { from: /box-shadow:\s*0\s*20px\s*60px\s*rgba\(0, 0, 0, 0\.4\),\s*0\s*0\s*30px\s*rgba\(205, 242, 43, 0\.05\);/g, to: 'box-shadow: 0 10px 40px rgba(32, 54, 39, 0.1);' },

    // Buttons
    { from: /background:\s*#CDF22B;\s*color:\s*#080C17;/g, to: 'background: #E8FF40;\n    color: #203627;' },
    { from: /box-shadow:\s*0\s*4px\s*20px\s*rgba\(205, 242, 43, 0\.35\);/g, to: 'box-shadow: 0 4px 20px rgba(232, 255, 64, 0.35);' },
    { from: /box-shadow:\s*0\s*8px\s*30px\s*rgba\(205, 242, 43, 0\.5\);/g, to: 'box-shadow: 0 8px 30px rgba(232, 255, 64, 0.5);' },
    { from: /color:\s*#CDF22B;\s*border:\s*1\.5px\s*solid\s*rgba\(205, 242, 43, 0\.4\);/g, to: 'color: #203627;\n    background: #9DC4D5;\n    border: 1.5px solid #9DC4D5;' },
    { from: /background:\s*rgba\(205, 242, 43, 0\.1\);\s*border-color:\s*#CDF22B;/g, to: 'background: #E8FF40;\n    border-color: #E8FF40;' },
    { from: /border:\s*1\.5px\s*solid\s*rgba\(248, 250, 252, 0\.2\);/g, to: 'border: 1.5px solid #9DC4D5;' },
    { from: /background:\s*rgba\(248, 250, 252, 0\.06\);\s*border-color:\s*rgba\(248, 250, 252, 0\.4\);/g, to: 'background: #9DC4D5;\n    border-color: #9DC4D5;\n    color: #203627;' },

    // Inputs
    { from: /background:\s*rgba\(0, 0, 0, 0\.3\);\s*border:\s*1\.5px\s*solid\s*rgba\(248, 250, 252, 0\.15\);/g, to: 'background: #EFEFEF;\n    border: 1.5px solid #9DC4D5;' },
    { from: /color:\s*rgba\(248, 250, 252, 0\.35\);/g, to: 'color: rgba(32, 54, 39, 0.5);' },
    { from: /border-color:\s*#CDF22B;/g, to: 'border-color: #E8FF40;' },
    { from: /box-shadow:\s*0\s*0\s*0\s*3px\s*rgba\(205, 242, 43, 0\.15\);/g, to: 'box-shadow: 0 0 0 3px rgba(232, 255, 64, 0.2);' },
    { from: /color:\s*rgba\(248, 250, 252, 0\.6\);/g, to: 'color: rgba(32, 54, 39, 0.7);' },

    // Navbar (Dark Green)
    { from: /background:\s*rgba\(0, 0, 0, 0\.4\);\s*backdrop-filter:[^}]+border:\s*1px\s*solid\s*rgba\(248, 250, 252, 0\.12\);/g, to: 'background: #203627;\n    border: 1px solid #9DC4D5;' },
    { from: /background:\s*rgba\(0, 0, 0, 0\.5\);\s*box-shadow:\s*0\s*8px\s*40px\s*rgba\(0,0,0,0\.6\),\s*0\s*0\s*0\s*1px\s*rgba\(205, 242, 43,0\.08\);/g, to: 'background: #203627;\n    box-shadow: 0 8px 40px rgba(32, 54, 39, 0.6), 0 0 0 1px #9DC4D5;' },
    { from: /color:\s*#CDF22B;\s*background:\s*rgba\(205, 242, 43, 0\.1\);/g, to: 'color: #E8FF40;\n    background: rgba(232, 255, 64, 0.1);' },
    { from: /background:\s*#CDF22B;/g, to: 'background: #E8FF40;' },

    // Stat Cards
    { from: /border:\s*1px\s*solid\s*rgba\(248, 250, 252, 0\.1\);/g, to: 'border: 1px solid #9DC4D5;' },
    { from: /rgba\(205, 242, 43,0\.08\)/g, to: 'rgba(232, 255, 64, 0.08)' },
    { from: /border-color:\s*rgba\(248, 250, 252, 0\.25\);/g, to: 'border-color: #E8FF40;' },
    { from: /-webkit-text-fill-color:\s*transparent;/g, to: '-webkit-text-fill-color: #203627;' }, // Since stat value is dark green

    // Section title
    { from: /linear-gradient\(to\s*bottom,\s*#CDF22B,\s*#1E45FB\)/g, to: '#E8FF40' },
    
    // Progress bar
    { from: /linear-gradient\(90deg,\s*#CDF22B,\s*#1E45FB\)/g, to: '#E8FF40' },
    
    // Footer
    { from: /border-top:\s*1px\s*solid\s*rgba\(205, 242, 43, 0\.08\);/g, to: 'border-top: 1px solid #EFEFEF;' },
    { from: /background:\s*linear-gradient\(90deg,\s*transparent,\s*rgba\(205, 242, 43,0\.3\),\s*transparent\);/g, to: 'background: linear-gradient(90deg, transparent, rgba(239, 239, 239, 0.3), transparent);' },

    // Data table
    { from: /background:\s*rgba\(0, 0, 0, 0\.15\);/g, to: 'background: #EFEFEF;' },
    { from: /border-top:\s*1px\s*solid\s*rgba\(205, 242, 43,0\.06\);/g, to: 'border-top: 1px solid #9DC4D5;' },
    { from: /border-bottom:\s*1px\s*solid\s*rgba\(205, 242, 43,0\.06\);/g, to: 'border-bottom: 1px solid #9DC4D5;' },
    { from: /border-left:\s*1px\s*solid\s*rgba\(205, 242, 43,0\.06\);/g, to: 'border-left: 1px solid #9DC4D5;' },
    { from: /border-right:\s*1px\s*solid\s*rgba\(205, 242, 43,0\.06\);/g, to: 'border-right: 1px solid #9DC4D5;' },
    { from: /background:\s*rgba\(0, 0, 0, 0\.35\);/g, to: 'background: rgba(157, 196, 213, 0.2);' },

    // Mission Cards
    { from: /border:\s*1px\s*solid\s*rgba\(248, 250, 252, 0\.1\);/g, to: 'border: 1px solid #9DC4D5;' },
    { from: /rgba\(205, 242, 43,0\.4\)/g, to: '#9DC4D5' },
    
    // Portfolio Cards
    { from: /background:\s*rgba\(0, 0, 0, 0\.25\);\s*border:\s*1px\s*solid\s*rgba\(248, 250, 252, 0\.08\);/g, to: 'background: #EFEFEF;\n    border: 1px solid #9DC4D5;' },
    { from: /border-color:\s*rgba\(205, 242, 43, 0\.2\);/g, to: 'border-color: #E8FF40;' },

    // Profile Banner
    { from: /background:\s*#080C17;\s*border-radius:\s*20px\s*20px\s*0\s*0;/g, to: 'background: #203627;\n    border-radius: 20px 20px 0 0;' },
    { from: /border:\s*4px\s*solid\s*#080C17;/g, to: 'border: 4px solid #EFEFEF;' },
    { from: /color:\s*#080C17;/g, to: 'color: #203627;' },
];

const generalReplacements = [
    // Colors
    { from: /#080C17/gi, to: '#203627' }, // Dark Navy to Dark Green
    { from: /#CDF22B/gi, to: '#E8FF40' }, // Bright Yellow to Lemon Lime
    { from: /#1E45FB/gi, to: '#9DC4D5' }, // Golden Yellow to Sky Blue
    { from: /#F8FAFC/gi, to: '#EFEFEF' }, // Cream to Anti-Flesh White
    
    // Light text colors in content sections (inverting to dark green)
    { from: /color:\s*rgba\(248, 250, 252,\s*0\.6\)/g, to: 'color: rgba(32, 54, 39, 0.7)' },
    { from: /color:\s*rgba\(248, 250, 252,\s*0\.4\)/g, to: 'color: rgba(32, 54, 39, 0.6)' },
    { from: /color:\s*rgba\(248, 250, 252,\s*0\.3\)/g, to: 'color: rgba(32, 54, 39, 0.5)' },
    
    // Borders
    { from: /border:\s*1px\s*solid\s*rgba\(248, 250, 252,\s*0\.08\)/g, to: 'border: 1px solid #9DC4D5' },
    { from: /border:\s*1px\s*solid\s*rgba\(248, 250, 252,\s*0\.12\)/g, to: 'border: 1px solid #9DC4D5' },
    
    // Backgrounds for elements like badges, tags, pills
    { from: /background:\s*rgba\(248, 250, 252,\s*0\.04\)/g, to: 'background: #EFEFEF' },
    { from: /background:\s*rgba\(0,\s*0,\s*0,\s*0\.15\)/g, to: 'background: #EFEFEF' },
    
    // Hover borders
    { from: /borderColor='rgba\(205, 242, 43,0\.25\)'/g, to: "borderColor='#E8FF40'" },
    { from: /borderColor='rgba\(205, 242, 43,0\.08\)'/g, to: "borderColor='#9DC4D5'" },

    // Hardcoded dashboard gradients to plain EFEFEF with border
    { from: /background:linear-gradient\(135deg,rgba\(17, 24, 39,0\.8\)\s*0%,rgba\(38, 65, 47,0\.9\)\s*100%\);/g, to: 'background:#EFEFEF;' },
];

function processFile(filePath) {
    let content = fs.readFileSync(filePath, 'utf8');
    let original = content;

    if (filePath.endsWith('app.css')) {
        cssReplacements.forEach(r => {
            content = content.replace(r.from, r.to);
        });
        
        // Also apply general replacements to app.css for any remaining hex codes
        generalReplacements.forEach(r => {
            // Be careful not to revert the specific css replacements, but since they don't overlap in bad ways, it's fine.
            content = content.replace(r.from, r.to);
        });

        // Specific fix for text gradient in app.css
        content = content.replace(/.text-gradient {\s*background: #EFEFEF;\s*-webkit-background-clip: text;\s*-webkit-text-fill-color: transparent;\s*background-clip: text;\s*}/g, 
            '.text-gradient {\n    background: #203627;\n    -webkit-background-clip: text;\n    -webkit-text-fill-color: transparent;\n    background-clip: text;\n  }');
        
        content = content.replace(/.text-gradient-subtle {\s*background: #EFEFEF;\s*-webkit-background-clip: text;\s*-webkit-text-fill-color: transparent;\s*background-clip: text;\s*}/g, 
            '.text-gradient-subtle {\n    background: rgba(32, 54, 39, 0.8);\n    -webkit-background-clip: text;\n    -webkit-text-fill-color: transparent;\n    background-clip: text;\n  }');

    } else {
        // Blade and other files
        // First we do a specific fix for welcome.blade.php Hero text which should remain EFEFEF or 9DC4D5
        if (filePath.endsWith('welcome.blade.php')) {
            // Temporarily hide hero text from global replace
            content = content.replace(/color:#F8FAFC;/g, 'color:__HERO_TEXT__;');
            content = content.replace(/color: rgba\(248, 250, 252, 0\.6\);/g, 'color:__HERO_SUBTEXT__;');
            
            // Now apply general
            generalReplacements.forEach(r => {
                content = content.replace(r.from, r.to);
            });
            
            // Restore hero
            content = content.replace(/color:__HERO_TEXT__;/g, 'color:#EFEFEF;');
            content = content.replace(/color:__HERO_SUBTEXT__;/g, 'color:#9DC4D5;');

            // Fix Hero BG
            content = content.replace(/radial-gradient\(ellipse 80% 60% at 50% 0%, rgba\(0, 0, 0, 0\.4\) 0%, #203627 60%\)/g, '#203627');

            // Navbar in landing
            content = content.replace(/background:rgba\(0, 0, 0, 0\.4\)/g, 'background:#203627');
            content = content.replace(/background:rgba\(0, 0, 0, 0\.5\)/g, 'background:#203627');
        } else {
            generalReplacements.forEach(r => {
                content = content.replace(r.from, r.to);
            });

            // If the file is a dashboard or content file, we want background of page-wrapper to be light, 
            // but the page-wrapper class is in app.css, so we're good.
            // We just need to fix text that was #F8FAFC inline.
            content = content.replace(/color:#EFEFEF/g, 'color:#203627'); // Invert all light text to dark green in content files!
            
            // Exceptions where color must be EFEFEF: 
            // badge-cream text, nav-link text, button ghost text, etc.
            // Since those are classes, inline color:#EFEFEF usually means we need #203627 in content.
            // But wait, what if we just replaced #F8FAFC to #EFEFEF above? Yes! So now it's EFEFEF, we make it 203627.
        }
    }

    if (content !== original) {
        fs.writeFileSync(filePath, content, 'utf8');
        console.log(`Updated: ${filePath}`);
    }
}

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        file = path.join(dir, file);
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else { 
            if (file.endsWith('.php') || file.endsWith('.css')) {
                results.push(file);
            }
        }
    });
    return results;
}

const resourcesDir = path.join(__dirname, 'resources');
const files = walk(resourcesDir);

files.forEach(file => {
    processFile(file);
});

console.log("Done replacing colors v4.");
