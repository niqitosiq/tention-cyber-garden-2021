// init
let app = new PIXI.Application({ width: 1000, height: 1000 })
document.getElementById('container').appendChild(app.view)

let sprite = PIXI.Sprite.from('assets/sova.jpg')
app.stage.addChild(sprite)

// const g = new PIXI.Graphics();
// g.beginFill(0xDE3249);
// g.drawRect(50, 50, 100, 100);
// g.endFill();
//
// const path = [600, 370, 700, 460, 780, 420, 730, 570, 590, 520];
// g.lineStyle(0);
// g.beginFill(0x3500FA, 1);
// g.drawPolygon(path);
// g.endFill();
//
// app.stage.addChild(g);


//
// Text
//

const skewStyle = new PIXI.TextStyle({
    fontFamily: 'Arial',
    dropShadow: true,
    dropShadowAlpha: 0.8,
    dropShadowAngle: 2.1,
    dropShadowBlur: 4,
    dropShadowColor: '0x111111',
    dropShadowDistance: 10,
    fill: ['#ffffff'],
    stroke: '#004620',
    fontSize: 60,
    fontWeight: 'lighter',
    lineJoin: 'round',
    strokeThickness: 12,
});

for (let i = 0; i < 5; i++) {
    const skewText = new PIXI.Text('Власть шизам!', skewStyle)
    skewText.skew.set(i * 0.2, -0.1);
    skewText.anchor.set(0.2 + i*0.1, 0.5);
    skewText.x = 300 + i * 50;
    skewText.y = 480 + i * 60;
    app.stage.addChild(skewText);
}


const bezier = new PIXI.Graphics();

bezier.lineStyle(15, 0xAA0000, 1);
bezier.bezierCurveTo(100, 200, 200, 200, 240, 100);

bezier.position.x = 50;
bezier.position.y = 50;

app.stage.addChild(bezier);

///////////////
const t1 = new PIXI.Text('Помидорыыыы')
t1.x = 42
t1.y = 99

let points = []
for (let i = 0; i < 20; i++) {
    points.push(new PIXI.Point(i*i*0.5, i*15));
}
let rope = new PIXI.SimpleRope(t1.texture, points)



app.stage.addChild(t1);
app.stage.addChild(rope);
