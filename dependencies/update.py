from subprocess import call;
from os import listdir, remove;
from os.path import isfile, join;
import shutil, os;

origWD = os.getcwd() # remember our original working directory

os.chdir("./stomp-websocket/")
call("cake build", shell=True);
call("node_modules\\.bin\\uglifyjs -m --comments all -o ../../public/themes/frontend/tavern/assets/plugins/stomp-websocket/stomp.min.js lib/stomp.js", shell=True);

os.chdir(origWD) # get back to our original working directory

os.chdir("./sockjs-client/")

files = [ f for f in listdir("./build/") if isfile(join("./build/",f)) ];
for file in files:
    remove("./build/" + str(file));

call("npm install", shell=True);
call("gulp browserify:min", shell=True);
files = [ f for f in listdir("./build/") if isfile(join("./build/",f)) ];
for file in files:
    shutil.copy("./build/" + str(file), "../../public/themes/frontend/tavern/assets/plugins/sockjs-client/sockjs.min.js");
    
os.chdir(origWD) # get back to our original working directory