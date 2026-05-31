const fs = require('fs');
const path = require('path');

const replacements = [
    // 1. Remove muddy gradients
    { from: /linear-gradient\(135deg,\s*#E8FF40\s*0%,\s*#9DC4D5\s*100%\)/gi, to: '#E8FF40' },
    { from: /linear-gradient\(135deg,\s*#E8FF40,\s*#9DC4D5\)/gi, to: '#E8FF40' },
    { from: /linear-gradient\(135deg,#E8FF40,#9DC4D5\)/gi, to: '#E8FF40' },
    
    // Text gradients to solid
    { from: /linear-gradient\(135deg,\s*#E8FF40\s*0%,\s*#EFEFEF\s*60%,\s*#9DC4D5\s*100%\)/gi, to: '#EFEFEF' },
    { from: /linear-gradient\(135deg,\s*#EFEFEF\s*0%,\s*#E8FF40\s*100%\)/gi, to: '#EFEFEF' },
    { from: /linear-gradient\(135deg,#E8FF40,#EFEFEF\)/gi, to: '#EFEFEF' },

    // Background gradients to solid Dark Green
    { from: /linear-gradient\(160deg,\s*#203627\s*0%,\s*#203627\s*40%,\s*#203627\s*70%,\s*#203627\s*100%\)/gi, to: '#203627' },
    { from: /linear-gradient\(135deg,\s*rgba\(157,\s*196,\s*213,\s*0\.1\)\s*0%,\s*#203627\s*50%,\s*#203627\s*100%\)/gi, to: '#203627' },

    // 2. Change glass backgrounds from Sky Blue tint to pure Black tint (darkens the Dark Green)
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.05\s*\)/g, to: 'rgba(0, 0, 0, 0.1)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.06\s*\)/g, to: 'rgba(0, 0, 0, 0.15)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.08\s*\)/g, to: 'rgba(0, 0, 0, 0.2)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.09\s*\)/g, to: 'rgba(0, 0, 0, 0.25)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.1\s*\)/g, to: 'rgba(0, 0, 0, 0.3)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.12\s*\)/g, to: 'rgba(0, 0, 0, 0.35)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.15\s*\)/g, to: 'rgba(0, 0, 0, 0.4)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.2\s*\)/g, to: 'rgba(0, 0, 0, 0.5)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.25\s*\)/g, to: 'rgba(0, 0, 0, 0.6)' },

    // 3. Revert text opacity from Sky Blue tint back to Anti-Flesh White tint
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.8\s*\)/g, to: 'rgba(239, 239, 239, 0.4)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.7\s*\)/g, to: 'rgba(239, 239, 239, 0.35)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.6\s*\)/g, to: 'rgba(239, 239, 239, 0.3)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.5\s*\)/g, to: 'rgba(239, 239, 239, 0.25)' },
    { from: /rgba\(\s*157,\s*196,\s*213,\s*0\.4\s*\)/g, to: 'rgba(239, 239, 239, 0.2)' },
    
    // Solid Sky Blue text -> back to Anti-Flesh White with 0.6 opacity
    { from: /color:\s*#9DC4D5/gi, to: 'color: rgba(239, 239, 239, 0.6)' },

    // 4. Tone down the borders (Lemon Lime to Anti-Flesh White)
    { from: /border:\s*1px\s*solid\s*rgba\(\s*232,\s*255,\s*64,\s*0\.1\s*\)/g, to: 'border: 1px solid rgba(239, 239, 239, 0.1)' },
    { from: /border:\s*1px\s*solid\s*rgba\(\s*232,\s*255,\s*64,\s*0\.12\s*\)/g, to: 'border: 1px solid rgba(239, 239, 239, 0.12)' },
    { from: /border-color:\s*rgba\(\s*232,\s*255,\s*64,\s*0\.25\s*\)/g, to: 'border-color: rgba(239, 239, 239, 0.25)' },
    { from: /border-color:\s*rgba\(\s*232,\s*255,\s*64,\s*0\.3\s*\)/g, to: 'border-color: rgba(239, 239, 239, 0.3)' },
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

console.log("Done replacing colors v3.");
