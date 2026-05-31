const fs = require('fs');
const path = require('path');

const replacements = [
    { from: /#000053/gi, to: '#203627' },
    { from: /0,\s*0,\s*53/g, to: '32, 54, 39' },
    
    { from: /#000080/gi, to: '#2A4B36' },
    { from: /0,\s*0,\s*80/g, to: '42, 75, 54' },
    
    { from: /#0000b3/gi, to: '#355F45' },
    { from: /0,\s*0,\s*83/g, to: '42, 75, 54' },
    { from: /0,\s*0,\s*60/g, to: '38, 65, 47' },
    { from: /0,\s*0,\s*30/g, to: '28, 48, 35' },
    { from: /0,\s*0,\s*100/g, to: '48, 85, 62' },
    { from: /0,\s*0,\s*35/g, to: '30, 50, 37' },
    { from: /0,\s*0,\s*128/g, to: '60, 105, 75' },
    { from: /0,\s*0,\s*70/g, to: '40, 70, 50' },

    { from: /#ffefc7/gi, to: '#EFEFEF' },
    { from: /255,\s*239,\s*199/g, to: '239, 239, 239' },

    { from: /#ffd500/gi, to: '#E8FF40' },
    { from: /255,\s*213,\s*0/g, to: '232, 255, 64' },

    { from: /#fdc500/gi, to: '#9DC4D5' },
    { from: /253,\s*197,\s*0/g, to: '157, 196, 213' },
    
    { from: /#f5d98a/gi, to: '#D6D6D6' },

    { from: /#93c5fd/gi, to: '#9DC4D5' },
    { from: /96,\s*165,\s*250/g, to: '157, 196, 213' },
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

console.log("Done replacing colors.");
