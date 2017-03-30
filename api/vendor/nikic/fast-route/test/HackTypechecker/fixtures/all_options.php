<?hh

namespace Fast\TestFixtures;

function all_options_simple(): \Fast\Dispatcher {
    return \Fast\simpleDispatcher(
      $collector ==> {},
      shape(
        'Parser' => \Fast\Parser\Std::class,
        'dataGenerator' => \Fast\DataGenerator\GroupCountBased::class,
        'dispatcher' => \Fast\Dispatcher\GroupCountBased::class,
        'Collector' => \Fast\Collector::class,
      ),
    );
}

function all_options_cached(): \Fast\Dispatcher {
    return \Fast\cachedDispatcher(
      $collector ==> {},
      shape(
        'Parser' => \Fast\Parser\Std::class,
        'dataGenerator' => \Fast\DataGenerator\GroupCountBased::class,
        'dispatcher' => \Fast\Dispatcher\GroupCountBased::class,
        'Collector' => \Fast\Collector::class,
        'cacheFile' => '/dev/null',
        'cacheDisabled' => false,
      ),
    );
}
