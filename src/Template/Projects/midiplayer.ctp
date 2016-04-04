        <script src="../js/piano/three.js"></script>

        <script src="../js/piano/OrbitAndPanControls.js"></script>
        <script src="../js/piano/ColladaLoader.js"></script>

        <!-- extras -->
        <script src="../js/piano/base64binary.js" type="text/javascript"></script>

        <script src="../js/piano/MIDI/AudioDetect.js" type="text/javascript"></script>
        <script src="../js/piano/MIDI/LoadPlugin.js" type="text/javascript"></script>
        <script src="../js/piano/MIDI/Plugin.js" type="text/javascript"></script>
        <script src="../js/piano/MIDI/Player.js" type="text/javascript"></script>
        <script src="../js/piano/MIDI/Loader.js" type="text/javascript"></script>

        <script src="../js/piano/Window/DOMLoader.script.js" type="text/javascript"></script>

        <!-- jasmid package -->
        <script src="../js/piano/jasmid/stream.js"></script>
        <script src="../js/piano/jasmid/midifile.js"></script>
        <script src="../js/piano/jasmid/replayer.js"></script>

        <script type="text/javascript" src="../js/piano/dat.gui.js"></script>
        <script src="../js/timbre.dev.js"></script>
        <script></script>
<html>
    <head>


        <style>
            canvas
            {
                float: left;
              height: 600px;
              width: 600px;
  margin-top: -60px;
  padding-bottom: 15px;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
            }

            #info
            {position: absolute;
                height: 50%


            }

            a
            {
                color: #1e83ff;
            }

        </style>    
    </head>
    <body>        
        <script type="text/javascript">

            // Begin MIDI loader widger
            MIDI.loader = new widgets.Loader({
                message: "Loading: Soundfont..."
            });
            
            function smoothstep(a,b,x)
            {
                if( x<a ) return 0.0;
                if( x>b ) return 1.0;
                var y = (x-a)/(b-a);
                return y*y*(3.0-2.0*y);
            }
            function mix(a,b,x)
            {
                return a + (b - a)*Math.min(Math.max(x,0.0),1.0);
            }            

            var controls = new function()
            {
                this.key_attack_time = 9.0;
                this.key_max_rotation = 0.72;
                this.octave = 3.1;
                this.noteOnColor = [ 255, 0, 0, 1.0 ];
                this.play = function()
                    {
                        MIDI.Player.resume();
                    };
                this.stop = function()
                    {
                        MIDI.Player.stop();
                    }
            };
            

            var keyState = Object.freeze ({unpressed: {}, note_on: {}, pressed:{}, note_off:{} });


            var scene = new THREE.Scene();
            var camera = new THREE.PerspectiveCamera(30, window.innerWidth/window.innerHeight, 2.0, 5000);

            var keys_down = [];
            var keys_obj = [];
    
            var renderer = new THREE.WebGLRenderer({antialias:true});
            renderer.setSize(window.innerWidth, window.innerHeight);          
            renderer.shadowMapEnabled = true;  
            renderer.shadowMapSoft = true;
            renderer.shadowMapType = THREE.PCFSoftShadowMap;
            renderer.gammaInput = true;
            renderer.gammaOutput = true;
            renderer.physicallyBasedShading = true;

            document.body.appendChild(renderer.domElement);

            var material = new THREE.MeshLambertMaterial( { color: 0x606060} ) 

            floor = new THREE.Mesh( new THREE.PlaneGeometry( 8000, 8000 ), new THREE.MeshBasicMaterial( { color: 0xf0f0f0 } ) );
            floor.rotation.x = - 90 * ( Math.PI / 180 );
            floor.position.y = -0.45;
            floor.receiveShadow = true;
            floor.castShadow = true;
            scene.add( floor );
            scene.fog = new THREE.Fog( 0xffffff, 40, 50 );

            noteOnColor = new THREE.Color().setRGB(controls.noteOnColor[0]/256.0, controls.noteOnColor[1]/256.0, controls.noteOnColor[2]/256.0);

            init_lights();

            var loader = new THREE.ColladaLoader();

            loader.load( '../obj/piano.dae', prepare_scene );

            camera.position.x = -2.77;
            camera.position.z = 10.04;
            camera.position.y = 5.51;

            var cameraControls = new THREE.OrbitAndPanControls(camera, renderer.domElement);
            cameraControls.target.set(4.5,0,0);

            var clock = new THREE.Clock();

            function on_window_resize()
            {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();

                renderer.setSize( window.innerWidth, window.innerHeight );
            }    

            function init_lights()
            {
                //var spotlight = new THREE.SpotLight(0xffffff);
                var spotlight = new THREE.DirectionalLight(0xffffff);
                
                spotlight.position.set(1.0,2.4,-7.5);
                spotlight.target.position.set(6.0,-6,7);
                spotlight.shadowCameraVisible = false;
                spotlight.shadowDarkness = 0.75;
                spotlight.intensity = 1;
                spotlight.castShadow = true;
                spotlight.shadowMapWidth = 2048;
                spotlight.shadowMapHeight = 2048;

                spotlight.shadowCameraNear = 5.0;
                spotlight.shadowCameraFar = 20.0;
                spotlight.shadowBias = 0.0025;
                
                spotlight.shadowCameraLeft = -8.85;
                spotlight.shadowCameraRight = 5.5;
                spotlight.shadowCameraTop = 4;
                spotlight.shadowCameraBottom = 0;                
                scene.add(spotlight);
                
                var light = new THREE.DirectionalLight( 0xddffff, 0.5 );
                light.position.set( 1, 1, 1 ).normalize();
                scene.add( light );

                var light = new THREE.DirectionalLight( 0xff5555, 0.5 );
                light.position.set( -1, -1, -1 ).normalize();
                scene.add( light );
            }

            function prepare_scene( collada )
            {
                collada.scene.traverse(initialize_keys);                
                scene.add(collada.scene);                
            }

            function initialize_keys( obj)
            {
                keys_obj.push(obj);                
                obj.rotation.x = -Math.PI/4.0;
                obj.rotation.y = 0;
                obj.rotation.z = 0;
                obj.keyState = keyState.unpressed;
                obj.clock = new THREE.Clock(false);
                obj.castShadow = true;
                obj.receiveShadow = true;

                // only add meshes in the material redefinition (to make keys change their color when pressed)
                if (obj instanceof THREE.Mesh)
                {
                    old_material = obj.material;
                    obj.material = new THREE.MeshPhongMaterial( { color:old_material.color} );
                    obj.material.shininess = 35.0;
                    obj.material.specular = new THREE.Color().setRGB(0.25, 0.25, 0.25);;
                    obj.material.note_off = obj.material.color.clone();
                   
                }

            }

            function key_status (keyName, status)
            {
                var obj = scene.getObjectByName(keyName, true);
                if (obj != undefined)
                {                 
                    obj.clock.start();
                    obj.clock.elapsedTime = 0;
                    obj.keyState = status;
                }
            }

            function frame()
            {
                requestAnimationFrame(frame);

                var delta = clock.getDelta();
                
                update(delta);

                render(delta);

            }
            function update_key( obj, delta )
            {
                if (obj.keyState == keyState.note_on)
                {
                    obj.rotation.x = mix(-Math.PI/4.0, -controls.key_max_rotation, smoothstep(0.0, 1.0, controls.key_attack_time*obj.clock.getElapsedTime()));
                    if (obj.rotation.x >= -controls.key_max_rotation)
                    {
                        obj.keyState = keyState.pressed;
                        obj.clock.elapsedTime = 0;
                    }                    
                    obj.material.color = noteOnColor;
                }
                else if (obj.keyState == keyState.note_off)
                {
                    obj.rotation.x = mix(-controls.key_max_rotation, -Math.PI/4.0, smoothstep(0.0, 1.0, controls.key_attack_time*obj.clock.getElapsedTime()));
                    if (obj.rotation.x <= -Math.PI/4.0)
                    {
                        obj.keyState = keyState.unpressed;
                        obj.clock.elapsedTime = 0;
                    }
                    obj.material.color = obj.material.note_off;
                }
            }

            function update( delta )
            {
                cameraControls.update(delta);
                for(i in keys_obj)
                {
                    update_key(keys_obj[i], delta);
                }

            }
        
            function render( delta )
            {                
                renderer.render(scene, camera);
            };

            frame();

            function keyCode_to_note( keyCode)
            {
                var note = -1;
                var sustain = -1;
                //-----------------------------------
                if(   keyCode==90 )  note= 0; // C 0
                if(   keyCode==83 )  note= 1; // C#0
                if(   keyCode==88 )  note= 2; // D 0
                if(   keyCode==68 )  note= 3; // D#0
                if(   keyCode==67 )  note= 4; // E 0
                if(   keyCode==86 )  note= 5; // F 0
                if(   keyCode==71 )  note= 6; // F#0
                if(   keyCode==66 )  note= 7; // G 0
                if(   keyCode==72 )  note= 8; // G#0
                if(   keyCode==78 )  note= 9; // A 0
                if(   keyCode==74 )  note=10; // A#0
                if(   keyCode==77 )  note=11; // B 0
                if(   keyCode==188 ) note=12; // C 0

                //-----------------------------------
                if(   keyCode==81 )  note=12; // C 1
                if(   keyCode==50 )  note=13; // C#1
                if(   keyCode==87 )  note=14; // D 1
                if(   keyCode==51 )  note=15; // D#1
                if(   keyCode==69 )  note=16; // E 1
                if(   keyCode==82 )  note=17; // F 1
                if(   keyCode==53 )  note=18; // F#1
                if(   keyCode==84 )  note=19; // G 1
                if(   keyCode==54 )  note=20; // G#1
                if(   keyCode==89 )  note=21; // A 1
                if(   keyCode==55 )  note=22; // A#1
                if(   keyCode==85 )  note=23; // B 1
                //-----------------------------------
                if(   keyCode==73 )  note=24; // C 2
                if(   keyCode==57 )  note=25; // C#2
                if(   keyCode==79 )  note=26; // D 2
                if(   keyCode==48 )  note=27; // D#2
                if(   keyCode==80 )  note=28; // E 2
                if(   keyCode==219 ) note=29; // F 2
                if(   keyCode==187 ) note=30; // F#2
                if(   keyCode==221 ) note=31; // G 2
                //-----------------------------------
                if(   keyCode==190 ) note=14;
                if(   keyCode==191 ) note=16;

                if( note == -1 ) return -1;

                return ("_" + (note + controls.octave*12));

            }

            window.onkeydown = function(ev)
            {
                if (keys_down[ev.keyCode] != true)
                {
                    var note = keyCode_to_note(ev.keyCode);
                    var sustain = keyCode_to_note(ev.keyCode);
                    if (note != -1)
                    {
                        key_status(note, keyState.note_on);
                        keys_down[ev.keyCode] = true;                     

                        var delay = 0; // play one note every quarter second
                        var note = parseInt(note.substr(1))+21; // the MIDI note
                        var velocity = 127; // how hard the note hits
                        MIDI.setVolume(0, 127);   
                        MIDI.noteOn(0, note, velocity, delay);                        
                    }
                }            
            }            

            window.onkeyup = function(ev)
            {
                if (keys_down[ev.keyCode] == true)
                {
                    var note = keyCode_to_note(ev.keyCode);
                    var sustain = keyCode_to_note(ev.keyCode);

                    key_status(note, keyState.note_off);
                    keys_down[ev.keyCode] = false;

                    var delay = 2; // play one note every quarter second
                    var note = parseInt(note.substr(1))+21;
                    var velocity = 127;// how hard the note hits
                    MIDI.setVolume(0, 127);
                    MIDI.noteOff(0, note, delay + 0.08);
                }            

            }                  

            window.onload = function ()
            {
                MIDI.loadPlugin(function ()
                {
                    //MIDI.Player.loadFile(song[0], MIDI.Player.start);
                    MIDI.Player.timeWarp = 1.5; // speed the song is played back
                    MIDI.Player.loadFile("../webroot/midi/" + controls.song);                    
                    
                    MIDI.Player.addListener(function(data)
                    {
                        var pianoKey = data.note - MIDI.pianoKeyOffset - 3;
                        if (data.message === 144)
                        {
                            key_status("_" + pianoKey, keyState.note_on);
                        }
                        else
                        {
                            key_status("_" + pianoKey, keyState.note_off);
                        }
                    });

                    // Close the MIDI loader widget and open the GUI                                        
                    MIDI.loader.stop();
                    songsToFiles ={
                                    "Game Of Thrones Theme, Ramin Djawadi": "game_of_thrones.mid",                                
                                  };
                    var gui = new dat.GUI({ width:625});
                    //gui.add(controls, 'key_attack_time', 2.0 , 40.0);
                    //gui.add(controls, 'key_max_rotation',0.2 , 1.0);                             
                    var song = gui.add(controls, 'song', songsToFiles);
                    var noteOnColorControl = gui.addColor(controls, 'noteOnColor');
                    noteOnColorControl.onChange(function(value)
                                    {
                                        noteOnColor = new THREE.Color().setRGB(controls.noteOnColor[0]/256.0, controls.noteOnColor[1]/256.0, controls.noteOnColor[2]/256.0);;
                                    });

                    song.onChange(function(value)
                                    {
                                        MIDI.Player.stop();
                                        MIDI.Player.loadFile("midi/" + value, MIDI.Player.start);
                                    });

                    // make sure to remove any key pressed when changing the octave
                    var octave = gui.add(controls, 'octave',0 , 4).step(1);
                    octave.onChange(function(value)
                                    {
                                        for (keyCode in keys_down)
                                        {  
                                            var note = keyCode_to_note(keyCode);
                                            key_status(note, keyState.note_off);
                                        }
                                        
                                    });

                    gui.add(controls, 'play');
                    gui.add(controls, 'stop');
                });                               
            };            

            window.addEventListener( 'resize', on_window_resize, false );

        </script>

    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    </script>
    <script type="text/javascript">
    _uacct = "UA-302418-4";
    urchinTracker();
    </script>

    <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
    try
    {
      var pageTracker = _gat._getTracker("UA-302418-4");
      pageTracker._trackPageview();
    }
    catch(err)
    {
    }
    </script>
    <div id="info content">
        <br><br><br><br><br><br>
        <br>
        <br>
        <br><a href="http://threejs.org" target="_blank">three.js</a> - 3D Piano player by <a href="http://www.twitter.com/reality3d/" target="_blank">Borja Morales</a> <br />
        Controls: Keyboard to play, Mouse to orbit<br/>
        Uses <a href="http://mudcu.be/midi-../js/piano/" target="_blank">MIDI.js</a> Source code available on <a href="https://github.com/reality3d/3d-piano-player" target="_blank">Github</a><br/>
        <a href="http://www.twitter.com/reality3d/" target="_blank">Borja Morales</a>
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.rgba.org/r3d/3d-piano-player/" data-via="reality3d">Tweet</a>
        <br>

    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> 
</div>
    </body>
</html>