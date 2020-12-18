<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = '__root__';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'beberlei/doctrineextensions' => 'v1.3.0@008f162f191584a6c37c03a803f718802ba9dd9a',
  'clue/stream-filter' => 'v1.5.0@aeb7d8ea49c7963d3b581378955dbf5bc49aa320',
  'cmen/google-charts-bundle' => '3.2.1@da6baee249d841407bdfecee69a94402ae50afd2',
  'composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6',
  'doctrine/annotations' => '1.11.1@ce77a7ba1770462cd705a91a151b6c3746f9c6ad',
  'doctrine/cache' => '1.10.2@13e3381b25847283a91948d04640543941309727',
  'doctrine/collections' => '1.6.7@55f8b799269a1a472457bd1a41b4f379d4cfba4a',
  'doctrine/common' => '2.13.3@f3812c026e557892c34ef37f6ab808a6b567da7f',
  'doctrine/dbal' => '2.10.4@47433196b6390d14409a33885ee42b6208160643',
  'doctrine/doctrine-bundle' => '1.12.13@85460b85edd8f61a16ad311e7ffc5d255d3c937c',
  'doctrine/doctrine-cache-bundle' => '1.4.0@6bee2f9b339847e8a984427353670bad4e7bdccb',
  'doctrine/doctrine-migrations-bundle' => '3.0.1@96e730b0ffa0bb39c0f913c1966213f1674bf249',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '1.4.3@4650c8b30c753a76bf44fb2ed00117d6f367490c',
  'doctrine/instantiator' => '1.4.0@d56bf6102915de5702778fe20f2de3b2fe570b5b',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'doctrine/migrations' => '3.0.1@69eaf2ca5bc48357b43ddbdc31ccdffc0e2a0882',
  'doctrine/orm' => '2.7.5@01187c9260cd085529ddd1273665217cae659640',
  'doctrine/persistence' => '1.3.8@7a6eac9fb6f61bba91328f15aa7547f4806ca288',
  'doctrine/reflection' => '1.2.2@fa587178be682efe90d005e3a322590d6ebb59a5',
  'egulias/email-validator' => '2.1.24@ca90a3291eee1538cd48ff25163240695bd95448',
  'fig/link-util' => '1.1.1@c038ee75ca13663ddc2d1f185fe6f7533c00832a',
  'friendsofsymfony/user-bundle' => 'v2.1.2@1049935edd24ec305cc6cfde1875372fa9600446',
  'guzzlehttp/promises' => '1.4.0@60d379c243457e073cff02bc323a2a86cb355631',
  'guzzlehttp/psr7' => '1.7.0@53330f47520498c0ae1f61f7e2c90f55690c06a3',
  'http-interop/http-factory-guzzle' => '1.0.0@34861658efb9899a6618cef03de46e2a52c80fc0',
  'igorescobar/jquery-mask-plugin' => 'v1.14.1@678a7df1f0bb275ce53f365b91af99d86850978d',
  'jdorn/sql-formatter' => 'v1.2.17@64990d96e0959dff8e059dfcdc1af130728d92bc',
  'jean85/pretty-package-versions' => '1.5.1@a917488320c20057da87f67d0d40543dd9427f7a',
  'knplabs/knp-components' => 'v1.3.10@fc1755ba2b77f83a3d3c99e21f3026ba2a1429be',
  'knplabs/knp-paginator-bundle' => 'v2.8.0@f4ece5b347121b9fe13166264f197f90252d4bd2',
  'knplabs/knp-snappy' => 'v1.2.1@7bac60fb729147b7ccd8532c07df3f52a4afa8a4',
  'knplabs/knp-snappy-bundle' => 'v1.7.1@89a633d30d39b71b38511b70e1f0495164140933',
  'league/csv' => '9.6.2@f28da6e483bf979bac10e2add384c90ae9983e4e',
  'monolog/monolog' => '1.26.0@2209ddd84e7ef1256b7af205d0717fb62cfc9c33',
  'nikic/php-parser' => 'v4.10.3@dbe56d23de8fcb157bbc0cfb3ad7c7de0cfb0984',
  'ocramius/proxy-manager' => '2.2.3@4d154742e31c35137d5374c998e8f86b54db2e2f',
  'paragonie/random_compat' => 'v2.0.19@446fc9faa5c2a9ddf65eb7121c0af7e857295241',
  'php-http/client-common' => '2.3.0@e37e46c610c87519753135fb893111798c69076a',
  'php-http/discovery' => '1.13.0@788f72d64c43dc361e7fcc7464c3d947c64984a7',
  'php-http/httplug' => '2.2.0@191a0a1b41ed026b717421931f8d3bd2514ffbf9',
  'php-http/message' => '1.10.0@39db36d5972e9e6d00ea852b650953f928d8f10d',
  'php-http/message-factory' => 'v1.0.2@a478cb11f66a6ac48d8954216cfed9aa06a501a1',
  'php-http/promise' => '1.1.0@4c4c1f9b7289a2ec57cde7f1e9762a5789506f88',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.2.2@069a785b2141f5bcf49f3e353548dc1cce6df556',
  'phpdocumentor/type-resolver' => '1.4.0@6a467b8989322d92aa1c8bf2bebcc6e5c2ba55c0',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/link' => '1.0.0@eea8e8662d5cd3ae4517c9b864493f59fca95562',
  'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'scannerjs/scanner.js' => '2.10.3@cd93e550db1124ad0775bab3d1e4ef4204a9eb69',
  'sensio/framework-extra-bundle' => 'v5.4.1@585f4b3a1c54f24d1a8431c729fc8f5acca20c8a',
  'sentry/sdk' => '2.2.0@089858b1b27d3705a5fd1c32d8d10beb55980190',
  'sentry/sentry' => '2.5.1@62ef344463b2cceab745381214be353ee8ae5fc2',
  'sentry/sentry-symfony' => '3.5.3@839460734f50fc26a0276532ad9bf977c117bece',
  'swiftmailer/swiftmailer' => 'v6.2.4@56f0ab23f54c4ccbb0d5dcc67ff8552e0c98d59e',
  'symfony/apache-pack' => 'v1.0.1@3aa5818d73ad2551281fc58a75afd9ca82622e6c',
  'symfony/asset' => 'v3.4.47@0970d65388724df88c982111ec37c08457506ce3',
  'symfony/cache' => 'v3.4.47@a7a14c4832760bd1fbd31be2859ffedc9b6ff813',
  'symfony/class-loader' => 'v3.4.47@a22265a9f3511c0212bf79f54910ca5a77c0e92c',
  'symfony/config' => 'v3.4.47@bc6b3fd3930d4b53a60b42fe2ed6fc466b75f03f',
  'symfony/console' => 'v3.4.47@a10b1da6fc93080c180bba7219b5ff5b7518fe81',
  'symfony/debug' => 'v3.4.47@ab42889de57fdfcfcc0759ab102e2fd4ea72dcae',
  'symfony/debug-bundle' => 'v3.4.47@801ca5060ef44fe3e67f61fa53590251643045fa',
  'symfony/debug-pack' => 'v1.0.9@cfd5093378e9cafe500f05c777a22fe8a64a9342',
  'symfony/dependency-injection' => 'v3.4.47@51d2a2708c6ceadad84393f8581df1dcf9e5e84b',
  'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665',
  'symfony/doctrine-bridge' => 'v3.4.47@19a2e7616c8b2e478890f2fb48e6d51cf4600a91',
  'symfony/event-dispatcher' => 'v3.4.47@31fde73757b6bad247c54597beef974919ec6860',
  'symfony/expression-language' => 'v3.4.47@de38e66398fca1fcb9c48e80279910e6889cb28f',
  'symfony/filesystem' => 'v3.4.47@e58d7841cddfed6e846829040dca2cca0ebbbbb3',
  'symfony/finder' => 'v3.4.47@b6b6ad3db3edb1b4b1c1896b1975fb684994de6e',
  'symfony/flex' => 'v1.11.0@ceb2b4e612bd0b4bb36a4d7fb2e800c861652f48',
  'symfony/form' => 'v3.4.47@62e841f089ec485e5ee425308b56b6ce2b5d11fa',
  'symfony/framework-bundle' => 'v3.4.47@6c95e747b75ddd2af61152ce93bf87299d15710e',
  'symfony/http-client' => 'v5.2.0@5b9fc5d85a6cec73832ff170ccd468d97dd082d9',
  'symfony/http-client-contracts' => 'v2.3.1@41db680a15018f9c1d4b23516059633ce280ca33',
  'symfony/http-foundation' => 'v3.4.47@b9885fcce6fe494201da4f70a9309770e9d13dc8',
  'symfony/http-kernel' => 'v3.4.47@a98a4c30089e6a2d52a9fa236f718159b539f6f5',
  'symfony/inflector' => 'v3.4.47@b557c5d061b72cadf454dd87cd1308d0710c8021',
  'symfony/intl' => 'v3.4.47@c0e22a40039977f11dc4de03a853ab9450c2b4cd',
  'symfony/lts' => 'v3@3a4e88df038e3197e6b66d091d2495fd7d255c0b',
  'symfony/maker-bundle' => 'v1.25.0@6d2da12632f5c8b9aa7b159f0bb46f245289434a',
  'symfony/monolog-bridge' => 'v3.4.47@93915f0d981bc166dfa475698124435327f6ee63',
  'symfony/monolog-bundle' => 'v3.6.0@e495f5c7e4e672ffef4357d4a4d85f010802f940',
  'symfony/options-resolver' => 'v3.4.47@c7efc97a47b2ebaabc19d5b6c6b50f5c37c92744',
  'symfony/orm-pack' => 'v1.0.8@c9bcc08102061f406dc908192c0f33524a675666',
  'symfony/polyfill-apcu' => 'v1.20.0@f5191eb0e98e08d12eb49fc0ed0820e37de89fdf',
  'symfony/polyfill-ctype' => 'v1.20.0@f4ba089a5b6366e453971d3aad5fe8e897b37f41',
  'symfony/polyfill-intl-icu' => 'v1.20.0@c44d5bf6a75eed79555c6bf37505c6d39559353e',
  'symfony/polyfill-intl-idn' => 'v1.20.0@3b75acd829741c768bc8b1f84eb33265e7cc5117',
  'symfony/polyfill-intl-normalizer' => 'v1.20.0@727d1096295d807c309fb01a851577302394c897',
  'symfony/polyfill-mbstring' => 'v1.20.0@39d483bdf39be819deabf04ec872eb0b2410b531',
  'symfony/polyfill-php72' => 'v1.20.0@cede45fcdfabdd6043b3592e83678e42ec69e930',
  'symfony/polyfill-php73' => 'v1.20.0@8ff431c517be11c78c48a39a66d37431e26a6bed',
  'symfony/polyfill-php80' => 'v1.20.0@e70aa8b064c5b72d3df2abd5ab1e90464ad009de',
  'symfony/polyfill-uuid' => 'v1.20.0@7095799250ff244f3015dc492480175a249e7b55',
  'symfony/process' => 'v3.4.47@b8648cf1d5af12a44a51d07ef9bf980921f15fca',
  'symfony/profiler-pack' => 'v1.0.5@29ec66471082b4eb068db11eb4f0a48c277653f7',
  'symfony/property-access' => 'v3.4.47@f1dc91d0c987f3ba95be1d7874527d11477b25ff',
  'symfony/property-info' => 'v3.4.47@a5f1e77c881342a5b1e05fdc12642650853bd112',
  'symfony/routing' => 'v3.4.47@3e522ac69cadffd8131cc2b22157fa7662331a6c',
  'symfony/security' => 'v3.4.47@7f924370b6fc5927d7561ce2b6fb2b4ceccba63e',
  'symfony/security-bundle' => 'v3.4.47@8c23ac77dfb9cc48f1244b52528ff5331c6c08f6',
  'symfony/serializer' => 'v3.4.47@6d69ccc1dcfb64c1e9c9444588643e98718d1849',
  'symfony/serializer-pack' => 'v1.0.4@61173947057d5e1bf1c79e2a6ab6a8430be0602e',
  'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1',
  'symfony/stopwatch' => 'v3.4.47@298b81faad4ce60e94466226b2abbb8c9bca7462',
  'symfony/swiftmailer-bundle' => 'v3.3.1@defa9bdfc0191ed70b389cb93c550c6c82cf1745',
  'symfony/templating' => 'v3.4.47@84ca10f95aaff084ae2bcfc5c21ae551af173d5a',
  'symfony/translation' => 'v3.4.47@be83ee6c065cb32becdb306ba61160d598b1ce88',
  'symfony/twig-bridge' => 'v3.4.47@090d19d6f1ea5b9e1d79f372785aa5e5c9cd4042',
  'symfony/twig-bundle' => 'v3.4.47@977b3096e2df96bc8a8d2329e83466cfc30c373d',
  'symfony/validator' => 'v3.4.47@d25ceea5c99022aecf37adf157c76c31fc5dcbed',
  'symfony/var-dumper' => 'v3.4.47@0719f6cf4633a38b2c1585140998579ce23b4b7d',
  'symfony/web-link' => 'v3.4.47@f6f59213d07ec99f1000ba4915ec9d99d691b367',
  'symfony/web-profiler-bundle' => 'v3.4.47@ccb83b3a508f4a683e44f571f127beebdc315ff9',
  'symfony/webpack-encore-bundle' => 'v1.8.0@c879bc50c69f6b4f2984b2bb5fe8190bbc5befdd',
  'symfony/webpack-encore-pack' => 'v1.0.3@8d7f51379d7ae17aea7cf501d910a11896895ac4',
  'symfony/yaml' => 'v3.4.47@88289caa3c166321883f67fe5130188ebbb47094',
  'twbs/bootstrap' => 'v4.5.3@a716fb03f965dc0846df479e14388b1b4b93d7ce',
  'twig/extensions' => 'v1.5.4@57873c8b0c1be51caa47df2cdb824490beb16202',
  'twig/twig' => 'v2.14.1@5eb9ac5dfdd20c3f59495c22841adc5da980d312',
  'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389',
  'zendframework/zend-code' => '3.4.1@268040548f92c2bfcba164421c1add2ba43abaaa',
  'zendframework/zend-eventmanager' => '3.2.1@a5e2583a211f73604691586b8406ff7296a946dd',
  'symfony/browser-kit' => 'v3.4.47@9590bd3d3f9fa2f28d34b713ed4765a8cc8ad15c',
  'symfony/css-selector' => 'v3.4.47@da3d9da2ce0026771f5fe64cb332158f1bd2bc33',
  'symfony/dom-crawler' => 'v3.4.47@ef97bcfbae5b384b4ca6c8d57b617722f15241a6',
  'symfony/dotenv' => 'v3.4.47@1022723ac4f56b001d99691d96c6025dbf1404f1',
  'symfony/phpunit-bridge' => 'v3.4.47@120273ad5d03a8deee08ca9260e2598f288f2bac',
  'symfony/web-server-bundle' => 'v3.4.47@19c719f230d29e772a3f769a23a80c88179e8112',
  'symfony/polyfill-iconv' => '*@43c9b01b39c67dd2a15888283485e5d70c99d9fd',
  'symfony/polyfill-php70' => '*@43c9b01b39c67dd2a15888283485e5d70c99d9fd',
  'symfony/polyfill-php56' => '*@43c9b01b39c67dd2a15888283485e5d70c99d9fd',
  '__root__' => 'dev-master@43c9b01b39c67dd2a15888283485e5d70c99d9fd',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
