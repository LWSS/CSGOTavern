/* Credit goes Mombasa for the majority of this: http://codepen.io/Mombasa/ */
// Renderer
var renderer	= new THREE.WebGLRenderer( {
    antialias	: false,
    precision 	: "lowp",
    stencil 	: false,
} );
renderer.setClearColor(  new THREE.Color( 0x181525 ), 1  )
renderer.setSize(  document.getElementById("page-body").clientWidth, Metronic.getViewPort().height  );
renderer.shadowMapEnabled = true;
document.getElementById("page-body").appendChild(  renderer.domElement  );

var scene	 = new THREE.Scene(  );
var camera = new THREE.PerspectiveCamera( 90, document.getElementById("page-body").clientWidth / Metronic.getViewPort().height, 0.01, 1000 );   // Camera -- (  FOV, Aspect, Near, Far  )

var renderFuncs= []; // Array of functions for the rendering loop
var step = 0; // Progress in the Scene

/* Function Returning : Random between min and max */
var randInt = function(  min,max  ) {
    return ( ~~( ( Math.random()*max )+min ) ); // double tilde converts value to an integer number (  Math.random floating point  )
}

// Lights
var light = new THREE.PointLight(  0xffffff, 0.3  );
light.position.x = 0;
light.position.y = 10;
light.position.z = 0;
scene.add( light );

var light2 = new THREE.PointLight( 0xffffff, 1 );
light2.position.x = 200;
light2.position.y = 200;
light2.position.z = 200;
scene.add( light2 );

spotLight = new THREE.SpotLight( 0xffffff );
spotLight.position.set( 450, 700, 450 );
spotLight.target.position = new THREE.Vector3( 0,110,800 );
spotLight.intensity = 1;
spotLight.shadowDarkness = 2;
spotLight.castShadow = true;
spotLight.shadowMapWidth = 32;
spotLight.shadowMapHeight = 32;
spotLight.shadowCameraFov = 30;
spotLight.angle = 0.8;
scene.add( spotLight );

// Building Variables
var numBuild = 50;
var diamBuild = 50;
var tabBuildLeft = [];
var tabBuildRight = [];
var tabFaces = [4,8,15];
// Materials
var normalMaterial = new THREE.MeshPhongMaterial( {
    color      :  new THREE.Color( "rgb(40,40,40)" ),
    emissive   :  new THREE.Color( "rgb(20,20,20)" ),
    specular   :  new THREE.Color( "rgb(40,40,40)" ),
    metal 	   : true,
    opacity    : 1,
    shading    : THREE.FlatShading,
    shininess  : 50,
    transparent: 1,
} );
var blackMaterial = new THREE.MeshPhongMaterial( {
    color      :  new THREE.Color( "rgb(40,40,40)" ),
    emissive   :  new THREE.Color( "rgb(20,20,20)" ),
    specular   :  new THREE.Color( "rgb(40,40,40)" ),
    metal 	   : true,
    opacity    : 1,
    shading    : THREE.FlatShading,
    shininess  : 30,
    transparent: 1,
} );
var blueMaterial = new THREE.MeshPhongMaterial( {
    color      :  new THREE.Color( "rgb(50,50,50)" ),
    emissive   :  new THREE.Color( "rgb(20,20,20)" ),
    specular   :  new THREE.Color( "rgb(0,0,0)" ),
    metal 	   : true,
    opacity    : 1,
    shading    : THREE.FlatShading,
    shininess  : 70,
    transparent: 1,

} );
var matArray = [normalMaterial,blueMaterial,blackMaterial];

var groundMaterial = new THREE.MeshPhongMaterial( {
    color     :  0x404040,
    emissive  :  0x222222,
    specular  :  0x737373,
    shininess  :  30,
    shading    :  THREE.FlatShading,
    opacity    : 1
} );

// Background Sky Sphere
var backgroundSphere = new THREE.Mesh(  new THREE.SphereGeometry( 200, 10, 10 ), new THREE.MeshPhongMaterial(  {
    color      :  new THREE.Color( "rgb(40,40,40)" ),
    emissive   :  new THREE.Color( "rgb(10,10,10)" ),
    specular   :  new THREE.Color( "rgb(60,60,60)" ),
    shininess  :  100,
    transparent: 1,
    opacity    : 1,
    side: THREE.BackSide
} ) );
scene.add(  backgroundSphere  );

// Ground
var circleGround = new THREE.Mesh(  new THREE.CylinderGeometry( 250, 0, 0, 0  ), groundMaterial  );
circleGround.position.y = 0;
circleGround.receiveShadow = true;
circleGround.castShadow = true;
scene.add( circleGround );

function buildBoxLeft ( inx ){
    this.b = new THREE.Mesh( new THREE.BoxGeometry(  randInt( 3,4 ), randInt( 10,80 ), randInt( 3,4 ) ), matArray[randInt( 0,matArray.length )] );
    this.b.position.x = Math.cos( inx*( Math.PI*2 )/numBuild )*diamBuild;
    this.b.position.y = 0;
    this.b.position.z = Math.sin( inx*( Math.PI*2 )/numBuild )*diamBuild;
    this.b.lookAt( new THREE.Vector3( 0,0,0 ) );
    this.b.receiveShadow = true;
    this.b.castShadow = true;
}
function buildBoxRight ( inx ){
    this.b = new THREE.Mesh( new THREE.BoxGeometry(  randInt( 3,6 ), randInt( 10,80 ), randInt( 3,4 ) ), matArray[randInt( 0,matArray.length )] );
    this.b.position.x = Math.cos( inx*( Math.PI*2 )/numBuild )*( diamBuild+15 );
    this.b.position.y = 0;
    this.b.position.z = Math.sin( inx*( Math.PI*2 )/numBuild )*( diamBuild+15 );
    this.b.lookAt( new THREE.Vector3( 0,0,0 ) );
    this.b.receiveShadow = true;
    this.b.castShadow = true;
}
for( var i=0; i<numBuild; i++ ){
    tabBuildLeft.push( new buildBoxLeft( i ) );
    scene.add( tabBuildLeft[i].b );
}
for( var i=0; i<numBuild; i++ ){
    tabBuildRight.push( new buildBoxRight( i ) );
    scene.add( tabBuildRight[i].b );
}

//////////////////////////////////////////////////////////////////////////////////
//		render the whole thing on the page
//////////////////////////////////////////////////////////////////////////////////
// handle window resize
window.addEventListener( 'resize', function(){
    renderer.setSize(  document.getElementById("page-body").clientWidth, Metronic.getViewPort().height  )
    camera.aspect	= document.getElementById("page-body").clientWidth / Metronic.getViewPort().height
    camera.updateProjectionMatrix(  )
}, false )
// render the scene
renderFuncs.push( function(){
    renderer.render(  scene, camera  );
    camera.position.x = Math.cos( step )*60;
    camera.position.y = 4;
    camera.position.z = Math.sin( step )*60;
    camera.lookAt( new THREE.Vector3(  Math.cos( step+1 )*58, 40, Math.sin( step+1 )*58 )  );
    step += 0.0025;
} )

// run the rendering loop
var lastTimeMsec= null
requestAnimationFrame( function animate( nowMsec ){
    // keep looping
    requestAnimationFrame(  animate  );
    // measure time
    lastTimeMsec	= lastTimeMsec || nowMsec-1000/60
    var deltaMsec	= Math.min( 200, nowMsec - lastTimeMsec )
    lastTimeMsec	= nowMsec
    // call each update function
    renderFuncs.forEach( function( onRenderFct ){
        onRenderFct( deltaMsec/1000, nowMsec/1000 )
    } )
} )