<?hh

namespace Fast\TestFixtures;

function no_options_simple(): \Fast\Dispatcher {
    return \Fast\simpleDispatcher($collector ==> {});
}

function no_options_cached(): \Fast\Dispatcher {
    return \Fast\cachedDispatcher($collector ==> {});
}
