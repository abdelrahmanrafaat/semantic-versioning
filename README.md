# semantic-versioning

PHP package for parsing, comparing and modifying semantic versions

---
### Some theory about semantic versions

#### What is a semantic version ?

- It`s a set of rules or conventions for documenting versions of a software

- A Software can be Project or Package or API

More detailed explination can be found => https://semver.org/

---

### Piecies of semantic version

#### Normal version
- The first and most important part of a semantic version

- Consists of three identifiers Major.Minor.Patch 

- The three identifiers must be (non-negative integers with noleading zeros) [0-9]

- Major identifier must not be zero 

- Minor and Patch identifiers can be zeros

- Major identifier has higher precedence than Minor identifier and Minor identifier has higher precedence than Patch identifier

- Example: 1.0.0 or 1.1.1 or 2.9.4

#### Pre Release
- The secound part of a semantic version

- Comes after the normal version and starts with a hyphen -

- Consists of one or more non-empty identifiers seperated by .

- Identifiers must be (alphanumeric characters with/without a hyphen) [0-9A-Za-z-] or (non-negative integers with noleading zeros) [0-9]

- Alphanumeric identifiers has higher precedence than integers identifiers

- Pre Release has lower precedence than Normal version

- Example: 1.0.0-alpha or 1.0.0-alpha.1 or 1.0.0-0.3.7 or 1.0.0-x.7.z.92

#### Build Meta Data
- The third part of a semantic version

- Comes after the normal version or pre release and starts with a hyphen +

- Consists of one or more non-empty identifiers seperated by .

- Identifiers must be (alphanumeric characters with/without a hyphen) [0-9A-Za-z-] or (non-negative integers with noleading zeros) [0-9]

- Build Meta data has no precedence when comparing two semantic versions

- Example: 1.0.0-alpha+001 or 1.0.0+20130313144700 or 1.0.0-beta+exp.sha.5114f85

---

 ### Package Installation
```
$ composer require 
```

---
 ### Package usage
 
```
use Abdelrahmanrafaat\SemanticVersion\SemanticVersion;

$packageVersion = (new SemanticVersion)->setVersion('1.3.0-beta+exp.sha.5114f85');

$packageVersion->getFullVersion();   //1.3.0-beta.1+exp.sha.5114f85
$packageVersion->getNormalVersion(); //1.3.0
$packageVersion->getPreRelease();    //beta.1
$packageVersion->getBuildMetaData(); //exp.sha.5114f85

$packageVersion->getMajorVersion(); //1
$packageVersion->getMinorVersion(); //3
$packageVersion->getPatchVersion(); //0


$packageVersion->pumpMajor();
$packageVersion->getMajorVersion();  //2
$packageVersion->getNormalVersion(); //2.0.0

$packageVersion->pumpMinor();
$packageVersion->getMinorVersion(); //1
$packageVersion->getNormalVersion(); //2.1.0

$packageVersion->pumpPatch();
$packageVersion->getPatchVersion(); //1
$packageVersion->getNormalVersion(); //2.1.1

```

#### Comparing two versions
- Depends on the precedence of normal version and pre release
- Build meta data gets ignored when comparing two semantic versions

```
$firstVersion   = (new SemanticVersion)->setVersion('1.1.1');
$secoundVersion = (new SemanticVersion)->setVersion('1.1.1');

$firstVersion->equals($secoundVersion); //true

$firstVersion->pumpMajor();
$firstVersion->equals($secoundVersion); //false
$firstVersion->greaterThan($secoundVersion); //true
$secoundVersion->lessThan($firstVersion); //true

$firstVersion = (new SemanticVersion)->setVersion('1.0.0-alpha');
$secoundVersion = (new SemanticVersion)->setVersion('1.0.0-rc');

$firstVersion->equals($secoundVersion); //false
$firstVersion->lessThan($secoundVersion); //true
$secoundVersion->greaterThan($firstVersion); //false
```

