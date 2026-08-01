var fs = require('fs');
var path = require('path');

module.exports = function manifestBuilder(manifestPath) {
  var manifestDir = path.dirname(manifestPath);
  var manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
  var source = path.join(manifestDir, '/');
  var dist = 'dist/';

  function dependencyGlobs(dep) {
    var globs = (dep.files || []).map(function(file) {
      return source + file;
    });

    return globs;
  }

  function forEachDependency(type, callback) {
    Object.keys(manifest.dependencies || {}).forEach(function(name) {
      var dep = manifest.dependencies[name];
      if (type === 'css' && name.slice(-4) === '.css') {
        callback({
          type: 'css',
          name: name,
          globs: dependencyGlobs(dep)
        });
      }

      if (type === 'js' && name.slice(-3) === '.js') {
        callback({
          type: 'js',
          name: name,
          globs: dependencyGlobs(dep)
        });
      }
    });
  }

  return {
    paths: {
      source: source,
      dist: dist
    },
    config: manifest.config || {},
    globs: {
      fonts: [source + 'fonts/**/*'],
      images: [source + 'images/**/*']
    },
    getProjectGlobs: function() {
      var globs = [];
      forEachDependency('css', function(dep) {
        globs = globs.concat(dep.globs);
      });
      forEachDependency('js', function(dep) {
        globs = globs.concat(dep.globs);
      });
      return globs;
    },
    forEachDependency: forEachDependency
  };
};
