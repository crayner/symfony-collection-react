'use strict';

import React from 'react'
import { render } from 'react-dom'
import CollectionApp from './Collection/CollectionApp'

render(
    <CollectionApp
        translations={window.COLLECTION_PROPS.translations}
        locale={window.COLLECTION_PROPS.locale}
    />,
    document.getElementById(window.COLLECTION_PROPS.collection_element)
)
