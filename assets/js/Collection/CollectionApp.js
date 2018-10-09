'use strict';

import React, { Component } from "react"
import PropTypes from 'prop-types'

export default class CollectionApp extends Component {
    constructor(props) {
        super(props)

        this.state = {
            message: ''
        }

        this.translations = props.translations
    }
}

CollectionnApp.propTypes = {
    translations: PropTypes.object.isRequired,
}
