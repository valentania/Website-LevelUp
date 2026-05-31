const fs = require('fs');
const path = require('path');

const replacements = [
    // 1. Fix remaining Navy colors
    { from: /#00003a/gi, to: '#203627' },
    { from: /#000060/gi, to: '#203627' },
    { from: /#000070/gi, to: '#203627' },
    { from: /#000035/gi, to: '#203627' },

    // 2. Map the dark green "glass" backgrounds to Sky Blue tinted glass to use the 4th color properly!
    // (These were previously navy, mapped to dark green in my first script)
    { from: /rgba\(\s*42,\s*75,\s*54,\s*0\.7\s*\)/g, to: 'rgba(157, 196, 213, 0.1)' },
    { from: /rgba\(\s*42,\s*75,\s*54,\s*0\.65\s*\)/g, to: 'rgba(157, 196, 213, 0.09)' },
    { from: /rgba\(\s*42,\s*75,\s*54,\s*0\.6\s*\)/g, to: 'rgba(157, 196, 213, 0.08)' },
    { from: /rgba\(\s*42,\s*75,\s*54,\s*0\.5\s*\)/g, to: 'rgba(157, 196, 213, 0.06)' },
    { from: /rgba\(\s*38,\s*65,\s*47,\s*0\.85\s*\)/g, to: 'rgba(157, 196, 213, 0.15)' },
    { from: /rgba\(\s*38,\s*65,\s*47,\s*0\.95\s*\)/g, to: 'rgba(157, 196, 213, 0.2)' },
    { from: /rgba\(\s*38,\s*65,\s*47,\s*0\.98\s*\)/g, to: 'rgba(157, 196, 213, 0.25)' },
    { from: /rgba\(\s*28,\s*48,\s*35,\s*0\.5\s*\)/g, to: 'rgba(157, 196, 213, 0.05)' },
    { from: /rgba\(\s*28,\s*48,\s*35,\s*0\.4\s*\)/g, to: 'rgba(157, 196, 213, 0.04)' },
    { from: /rgba\(\s*28,\s*48,\s*35,\s*0\.95\s*\)/g, to: 'rgba(157, 196, 213, 0.15)' },
    { from: /rgba\(\s*48,\s*85,\s*62,\s*0\.6\s*\)/g, to: 'rgba(157, 196, 213, 0.12)' },
    { from: /rgba\(\s*60,\s*105,\s*75,\s*0\.8\s*\)/g, to: 'rgba(157, 196, 213, 0.15)' },
    { from: /rgba\(\s*60,\s*105,\s*75,\s*0\.5\s*\)/g, to: 'rgba(157, 196, 213, 0.1)' },
    { from: /rgba\(\s*60,\s*105,\s*75,\s*0\.3\s*\)/g, to: 'rgba(157, 196, 213, 0.05)' },
    { from: /rgba\(\s*30,\s*50,\s*37,\s*0\.5\s*\)/g, to: 'rgba(157, 196, 213, 0.05)' },
    { from: /rgba\(\s*40,\s*70,\s*50,\s*0\.8\s*\)/g, to: 'rgba(157, 196, 213, 0.15)' },
    
    // Also change some solid backgrounds that were green-tinted
    { from: /#2A4B36/gi, to: 'rgba(157, 196, 213, 0.1)' },
    { from: /#355F45/gi, to: 'rgba(157, 196, 213, 0.15)' },

    // 3. Promote Sky Blue (#9DC4D5) in text!
    // The previous text was white with opacity. Let's make it solid Sky Blue or Sky Blue with opacity.
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.7\s*\)/g, to: '#9DC4D5' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.65\s*\)/g, to: '#9DC4D5' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.6\s*\)/g, to: '#9DC4D5' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.5\s*\)/g, to: '#9DC4D5' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.45\s*\)/g, to: '#9DC4D5' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.4\s*\)/g, to: 'rgba(157, 196, 213, 0.8)' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.35\s*\)/g, to: 'rgba(157, 196, 213, 0.7)' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.3\s*\)/g, to: 'rgba(157, 196, 213, 0.6)' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.25\s*\)/g, to: 'rgba(157, 196, 213, 0.5)' },
    { from: /rgba\(\s*239,\s*239,\s*239,\s*0\.2\s*\)/g, to: 'rgba(157, 196, 213, 0.4)' },
];

function processFile(filePath) {
    let content = fs.readFileSync(filePath, 'utf8');
    let changed = false;
    for (const {from, to} of replacements) {
        if (from.test(content)) {
            content = content.replace(from, to);
            changed = true;
        }
    }
    if (changed) {
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
            if (file.endsWith('.php') || file.endsWith('.css') || file.endsWith('.js')) {
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

console.log("Done replacing colors v2.");
