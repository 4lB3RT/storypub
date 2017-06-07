<?hh

namespace Fast\TestFixtures;

function empty_options_simple(): \Fast\Dispatcher {
    return \Fast\simpleDispatcher($collector ==> {}, shape());
}

function empty_options_cached(): \Fast\Dispatcher {
    return \Fast\cachedDispatcher($collector ==> {}, shape());
}
