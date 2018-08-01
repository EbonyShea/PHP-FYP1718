var Simulator;
(function (Simulator) {
    var Connection = (function () {
        function Connection() {
            this.value = false;
        }
        return Connection;
    })();
    Simulator.Connection = Connection;
    var Component = (function () {
        function Component(inputSize, outputSize) {
            this.inputs = new Array();
            this.inputValue = new Array();
            for (var i = 0; i < inputSize; ++i) {
                this.inputs.push(undefined);
                this.inputValue.push(false);
            }
            this.outputs = new Array();
            this.outputValue = new Array();
            for (var i = 0; i < outputSize; ++i) {
                this.outputs.push(Array());
                this.outputValue.push(false);
            }
        }
        Component.prototype.setInput = function (index, conn) {
            if (!(0 <= index && index < this.inputs.length)) {
                throw "Index greater than the number of slots available!";
            }
            if (this.inputs[index] != undefined) {
                throw "Input slot is already occupied!";
            }
            this.inputs[index] = conn;
            conn.next = this;
        };
        Component.prototype.setOutput = function (index, conn) {
            if (!(0 <= index && index < this.outputs.length)) {
                throw "Index greater than the number of slots available!";
            }
            this.outputs[index].push(conn);
        };
        Component.prototype.removeInput = function (index) {
            if (!(0 <= index && index < this.inputs.length)) {
                throw "Index greater than the number of slots available!";
            }
            if (this.inputs[index] == undefined) {
                throw "Trying to delete an empty slot!";
            }
            this.inputs[index] = undefined;
        };
        Component.prototype.removeOutput = function (index, conn) {
            if (!(0 <= index && index < this.outputs.length)) {
                throw "Index greater than the number of slots available!";
            }
            var toRemove = this.outputs[index].indexOf(conn);
            if (toRemove == -1) {
                throw "The output connection that is being removed doesn't exist!";
            }
            else {
                this.outputs[index].splice(toRemove, 1);
            }
        };
        Component.prototype.update = function () {
            var canUpdate = true;
            for (var i = 0; i < this.inputs.length; ++i) {
                if (this.inputs[i] == undefined || this.inputs[i].value == undefined) {
                    canUpdate = false;
                }
                else {
                    this.inputValue[i] = this.inputs[i].value;
                }
            }
            if (canUpdate) {
                console.log(this.name + " updated");
                this.evaluate();
                for (var i = 0; i < this.outputs.length; ++i) {
                    for (var j = 0; j < this.outputs[i].length; ++j) {
                        this.outputs[i][j].value = this.outputValue[i];
                        this.outputs[i][j].next.update();
                    }
                }
            }
        };
        return Component;
    })();
    Simulator.Component = Component;
    var activeComponents = {};
    function getComponent(name) {
        if (activeComponents[name] == undefined) {
            throw "Component doesn't exist!";
        }
        return activeComponents[name];
    }
    Simulator.getComponent = getComponent;
    function addComponent(name, component) {
        if (activeComponents[name] != undefined) {
            throw "Name already taken!";
        }
        activeComponents[name] = component;
    }
    Simulator.addComponent = addComponent;
    function connect(from, fromIdx, to, toIdx) {
        var conn = new Connection;
        console.log(from);
        console.log(to);
        from.setOutput(fromIdx, conn);
        to.setInput(toIdx, conn);
        from.update();
    }
    Simulator.connect = connect;
    function disconnect(from, fromIdx, to, toIdx) {
        from.removeOutput(fromIdx, to.inputs[toIdx]);
        to.removeInput(toIdx);
    }
    Simulator.disconnect = disconnect;
})(Simulator || (Simulator = {}));
/* ENDS HERE */
var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
var Components;
(function (Components) {
    var linkColor = "#aaa";
    var outputEndpoint = {
        endpoint: ["Dot", { radius: 8 }],
        paintStyle: { fillStyle: linkColor },
        isTarget: true,
        isSource: true,
        scope: "logicConnections",
        connectorStyle: { strokeStyle: linkColor, lineWidth: 6 },
        connector: ["Flowchart", {}],
        maxConnections: 10
    };
    var inputEndpoint = {
        endpoint: ["Dot", { radius: 8 }],
        paintStyle: { fillStyle: linkColor },
        isTarget: true,
        scope: "logicConnections",
        connectorStyle: { strokeStyle: linkColor, lineWidth: 6 },
        connector: ["Flowchart", {}],
        maxConnections: 1
    };
    var HTMLComponent = (function (_super) {
        __extends(HTMLComponent, _super);
        function HTMLComponent(nInputs, nOutputs, posx, posy, compName) {
            _super.call(this, nInputs, nOutputs);
            this.contDiv = $("<div id=" + this.name + "></div>").addClass("component").addClass(compName);
            $("#screen").append(this.contDiv);
            var spos = $("#screen").offset();
            Simulator.addComponent(this.name, this);
            this.contDiv.offset({ top: spos.top + posy, left: spos.left + posx });
            jsPlumb.draggable(this.contDiv, { containment: $("#screen") });
        }
        return HTMLComponent;
    })(Simulator.Component);
	
	//========== SWITCH GATE ==========//
    var Switch = (function (_super) {
        __extends(Switch, _super);
        function Switch(posx, posy) {
            this.name = Switch.componentName + Switch.compCount;
            Switch.compCount += 1;
            this.value = false;
            _super.call(this, 0, 1, posx, posy, Switch.componentName);
            this.contDiv.append($("<img src=\"simulator/gates/switch_off.png\"></>"));
            this.contDiv.click({ parent: this }, function (event) {
                if (event.data.parent.value) {
                    event.data.parent.value = false;
                    event.data.parent.contDiv.children("img").attr("src", "simulator/gates/switch_off.png");
                }
                else {
                    event.data.parent.value = true;
                    event.data.parent.contDiv.children("img").attr("src", "simulator/gates/switch_on.png");
                }
                event.data.parent.update();
            });
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Bottom" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.value;
            };
        }
        Switch.compCount = 0;
        Switch.componentName = "switch";
        return Switch;
    })(HTMLComponent);
    Components.Switch = Switch;
	//========== SWITCH GATE ==========//

	//========== LIGHT GATE ==========//
    var Light = (function (_super) {
        __extends(Light, _super);
        function Light(posx, posy) {
            this.name = Light.componentName + Light.compCount;
            Light.compCount += 1;
            _super.call(this, 1, 0, posx, posy, Light.componentName);
            this.contDiv.append($("<img src=\"simulator/gates/light_off.png\"></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Bottom" }, inputEndpoint).id = this.name + "-i0";
            this.evaluate = function () {
                if (this.inputValue[0]) {
                    this.contDiv.children("img").attr("src", "simulator/gates/light_on.png");
                }
                else {
                    this.contDiv.children("img").attr("src", "simulator/gates/light_off.png");
                }
            };
        }
        Light.prototype.removeInput = function (index) {
            _super.prototype.removeInput.call(this, index);
            this.contDiv.children("img").attr("src", "simulator/gates/light_off.png");
        };
        Light.compCount = 0;
        Light.componentName = "light";
        return Light;
    })(HTMLComponent);
    Components.Light = Light;
	//========== LIGHT GATE ==========//

	//========== NOT GATE ==========//
    var Not = (function (_super) {
        __extends(Not, _super);
        function Not(posx, posy) {
            this.name = Not.componentName + Not.compCount;
            Not.compCount += 1;
            _super.call(this, 1, 1, posx, posy, Not.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\" + Not.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Left" }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !this.inputValue[0];
            };
        }
        Not.compCount = 0;
        Not.componentName = "not";
        return Not;
    })(HTMLComponent);
    Components.Not = Not;
	//========== NOT GATE ==========//

	//========== AND GATE (2-input) ==========//
    var And = (function (_super) {
        __extends(And, _super);
        function And(posx, posy) {
            this.name = And.componentName + And.compCount;
            And.compCount += 1;
            _super.call(this, 2, 1, posx, posy, And.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + And.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.3, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.7, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.inputValue[0] && this.inputValue[1];
            };
        }
        And.compCount = 0;
        And.componentName = "and";
        return And;
    })(HTMLComponent);
    Components.And = And;
	//========== AND GATE (2-input) ==========//
	
	//========== AND GATE (3-input) ==========//
    var AAnd = (function (_super) {
        __extends(AAnd, _super);
        function AAnd(posx, posy) {
            this.name = AAnd.componentName + AAnd.compCount;
            AAnd.compCount += 1;
            _super.call(this, 3, 1, posx, posy, AAnd.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + AAnd.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.1, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.5, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.9, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.inputValue[0] && this.inputValue[1] && this.inputValue[2];
            };
        }
        AAnd.compCount = 0;
        AAnd.componentName = "aand";
        return AAnd;
    })(HTMLComponent);
    Components.AAnd = AAnd;
	//========== AND GATE (3-input) ==========//
	
	//========== AND GATE (4-input) ==========//
    var AAAnd = (function (_super) {
        __extends(AAAnd, _super);
        function AAAnd(posx, posy) {
            this.name = AAAnd.componentName + AAAnd.compCount;
            AAAnd.compCount += 1;
            _super.call(this, 4, 1, posx, posy, AAAnd.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + AAAnd.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.4, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.8, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 1.2, 0, 0] }, inputEndpoint).id = this.name + "-i3";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.inputValue[0] && this.inputValue[1] && this.inputValue[2] && this.inputValue[3];
            };
        }
        AAAnd.compCount = 0;
        AAAnd.componentName = "aaand";
        return AAAnd;
    })(HTMLComponent);
    Components.AAAnd = AAAnd;
	//========== AND GATE (4-input) ==========//
	
	//========== NAND GATE (2-input) ==========//
    var Nand = (function (_super) {
        __extends(Nand, _super);
        function Nand(posx, posy) {
            this.name = Nand.componentName + Nand.compCount;
            Nand.compCount += 1;
            _super.call(this, 2, 1, posx, posy, Nand.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + Nand.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.3, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.7, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(this.inputValue[0] && this.inputValue[1]);
            };
        }
        Nand.compCount = 0;
        Nand.componentName = "nand";
        return Nand;
    })(HTMLComponent);
    Components.Nand = Nand;
	//========== NAND GATE (2-input) ==========//
	
	//========== NAND GATE (3-input) ==========//
    var NNand = (function (_super) {
        __extends(NNand, _super);
        function NNand(posx, posy) {
            this.name = NNand.componentName + NNand.compCount;
            NNand.compCount += 1;
            _super.call(this, 3, 1, posx, posy, NNand.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + NNand.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.1, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.5, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.9, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(this.inputValue[0] && this.inputValue[1] && this.inputValue[2]);
            };
        }
        NNand.compCount = 0;
        NNand.componentName = "nnand";
        return NNand;
    })(HTMLComponent);
    Components.NNand = NNand;
	//========== NAND GATE (3-input) ==========//
	
	//========== NAND GATE (4-input) ==========//
    var NNNand = (function (_super) {
        __extends(NNNand, _super);
        function NNNand(posx, posy) {
            this.name = NNNand.componentName + NNNand.compCount;
            NNNand.compCount += 1;
            _super.call(this, 4, 1, posx, posy, NNNand.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + NNNand.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.4, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.8, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 1.2, 0, 0] }, inputEndpoint).id = this.name + "-i3";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(this.inputValue[0] && this.inputValue[1] && this.inputValue[2] && this.inputValue[3]);
            };
        }
        NNNand.compCount = 0;
        NNNand.componentName = "nnnand";
        return NNNand;
    })(HTMLComponent);
    Components.NNNand = NNNand;
	//========== NAND GATE (4-input) ==========//
	
	//========== OR GATE (2-input) ==========//
    var Or = (function (_super) {
        __extends(Or, _super);
        function Or(posx, posy) {
            this.name = Or.componentName + Or.compCount;
            Or.compCount += 1;
            _super.call(this, 2, 1, posx, posy, Or.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\" + Or.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.3, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.7, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.inputValue[0] || this.inputValue[1];
            };
        }
        Or.compCount = 0;
        Or.componentName = "or";
        return Or;
    })(HTMLComponent);
    Components.Or = Or;
	//========== OR GATE (2-input) ==========//
	
	//========== OR GATE (3-input) ==========//
    var OOr = (function (_super) {
        __extends(OOr, _super);
        function OOr(posx, posy) {
            this.name = OOr.componentName + OOr.compCount;
            OOr.compCount += 1;
            _super.call(this, 3, 1, posx, posy, OOr.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\" + OOr.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.1, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.5, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.9, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.inputValue[0] || this.inputValue[1] || this.inputValue[2];
            };
        }
        OOr.compCount = 0;
        OOr.componentName = "oor";
        return OOr;
    })(HTMLComponent);
    Components.OOr = OOr;
	//========== OR GATE (3-input) ==========//
	
	//========== OR GATE (4-input) ==========//
    var OOOr = (function (_super) {
        __extends(OOOr, _super);
        function OOOr(posx, posy) {
            this.name = OOOr.componentName + OOOr.compCount;
            OOOr.compCount += 1;
            _super.call(this, 4, 1, posx, posy, OOOr.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\" + OOOr.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.4, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.8, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 1.2, 0, 0] }, inputEndpoint).id = this.name + "-i3";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.inputValue[0] || this.inputValue[1] || this.inputValue[2] || this.inputValue[3];
            };
        }
        OOOr.compCount = 0;
        OOOr.componentName = "ooor";
        return OOOr;
    })(HTMLComponent);
    Components.OOOr = OOOr;
	//========== OR GATE (4-input) ==========//
	
	//========== NOR GATE (2-input) ==========//
    var Nor = (function (_super) {
        __extends(Nor, _super);
        function Nor(posx, posy) {
            this.name = Nor.componentName + Nor.compCount;
            Nor.compCount += 1;
            _super.call(this, 2, 1, posx, posy, Nor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\" + Nor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.3, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.7, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(this.inputValue[0] || this.inputValue[1]);
            };
        }
        Nor.compCount = 0;
        Nor.componentName = "nor";
        return Nor;
    })(HTMLComponent);
    Components.Nor = Nor;
	//========== NOR GATE (2-input) ==========//
	
	//========== NOR GATE (3-input) ==========//
    var NNor = (function (_super) {
        __extends(NNor, _super);
        function NNor(posx, posy) {
            this.name = NNor.componentName + NNor.compCount;
            NNor.compCount += 1;
            _super.call(this, 3, 1, posx, posy, NNor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\" + NNor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.1, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.5, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.9, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(this.inputValue[0] || this.inputValue[1] || this.inputValue[1]);
            };
        }
        NNor.compCount = 0;
        NNor.componentName = "nnor";
        return NNor;
    })(HTMLComponent);
    Components.NNor = NNor;
	//========== NOR GATE (3-input) ==========//
	
	//========== NOR GATE (4-input) ==========//
    var NNNor = (function (_super) {
        __extends(NNNor, _super);
        function NNNor(posx, posy) {
            this.name = NNNor.componentName + NNNor.compCount;
            NNNor.compCount += 1;
            _super.call(this, 4, 1, posx, posy, NNNor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\" + NNNor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.4, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.8, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 1.2, 0, 0] }, inputEndpoint).id = this.name + "-i3";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(this.inputValue[0] || this.inputValue[1] || this.inputValue[2] || this.inputValue[3]);
            };
        }
        NNNor.compCount = 0;
        NNNor.componentName = "nnnor";
        return NNNor;
    })(HTMLComponent);
    Components.NNNor = NNNor;
	//========== NOR GATE (4-input) ==========//
	
	//========== XOR GATE (2-input) ==========//
    var Xor = (function (_super) {
        __extends(Xor, _super);
        function Xor(posx, posy) {
            this.name = Xor.componentName + Xor.compCount;
            Xor.compCount += 1;
            _super.call(this, 2, 1, posx, posy, Xor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + Xor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.3, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.7, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = this.inputValue[0] ^ this.inputValue[1];
            };
        }
        Xor.compCount = 0;
        Xor.componentName = "xor";
        return Xor;
    })(HTMLComponent);
    Components.Xor = Xor;
	//========== XOR GATE (2-input) ==========//

	//========== XOR GATE (3-input) ==========//
    var XXor = (function (_super) {
        __extends(XXor, _super);
        function XXor(posx, posy) {
            this.name = XXor.componentName + XXor.compCount;
            XXor.compCount += 1;
            _super.call(this, 3, 1, posx, posy, XXor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + XXor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.1, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.5, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.9, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = (this.inputValue[0] ^ this.inputValue[1]) ^ this.inputValue[2] ;
            };
        }
        XXor.compCount = 0;
        XXor.componentName = "xxor";
        return XXor;
    })(HTMLComponent);
    Components.XXor = XXor;
	//========== XOR GATE (3-input) ==========//
	
	//========== XOR GATE (4-input) ==========//
    var XXXor = (function (_super) {
        __extends(XXXor, _super);
        function XXXor(posx, posy) {
            this.name = XXXor.componentName + XXXor.compCount;
            XXXor.compCount += 1;
            _super.call(this, 4, 1, posx, posy, XXXor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + XXXor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.4, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.8, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 1.2, 0, 0] }, inputEndpoint).id = this.name + "-i3";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = ((this.inputValue[0] ^ this.inputValue[1]) ^ this.inputValue[2]) ^ this.inputValue[3];
            };
        }
        XXXor.compCount = 0;
        XXXor.componentName = "xxxor";
        return XXXor;
    })(HTMLComponent);
    Components.XXXor = XXXor;
	//========== XOR GATE (4-input) ==========//
	
	//========== XNOR GATE (2-input) ==========//
    var Xnor = (function (_super) {
        __extends(Xnor, _super);
        function Xnor(posx, posy) {
            this.name = Xnor.componentName + Xnor.compCount;
            Xnor.compCount += 1;
            _super.call(this, 2, 1, posx, posy, Xnor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + Xnor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.3, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.7, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(this.inputValue[0] ^ this.inputValue[1]);
            };
        }
        Xnor.compCount = 0;
        Xnor.componentName = "xnor";
        return Xnor;
    })(HTMLComponent);
    Components.Xnor = Xnor;
	//========== XNOR GATE (2-input) ==========//
	
	//========== XNOR GATE (3-input) ==========//
    var XXnor = (function (_super) {
        __extends(XXnor, _super);
        function XXnor(posx, posy) {
            this.name = XXnor.componentName + XXnor.compCount;
            XXnor.compCount += 1;
            _super.call(this, 3, 1, posx, posy, XXnor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + XXnor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.1, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.5, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.9, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !((this.inputValue[0] ^ this.inputValue[1]) ^ this.inputValue[2]);
            };
        }
        XXnor.compCount = 0;
        XXnor.componentName = "xxnor";
        return XXnor;
    })(HTMLComponent);
    Components.XXnor = XXnor;
	//========== XNOR GATE (3-input) ==========//
	
	//========== XNOR GATE (4-input) ==========//
    var XXXnor = (function (_super) {
        __extends(XXXnor, _super);
        function XXXnor(posx, posy) {
            this.name = XXXnor.componentName + XXXnor.compCount;
            XXXnor.compCount += 1;
            _super.call(this, 4, 1, posx, posy, XXXnor.componentName);
            this.contDiv.append($("<img src=simulator/\gates\\"  + XXXnor.componentName + ".png\></>"));
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0, 0, 0] }, inputEndpoint).id = this.name + "-i0";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.4, 0, 0] }, inputEndpoint).id = this.name + "-i1";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 0.8, 0, 0] }, inputEndpoint).id = this.name + "-i2";
            jsPlumb.addEndpoint(this.contDiv, { anchor: [0, 1.2, 0, 0] }, inputEndpoint).id = this.name + "-i3";
            jsPlumb.addEndpoint(this.contDiv, { anchor: "Right" }, outputEndpoint).id = this.name + "-o0";
            this.evaluate = function () {
                this.outputValue[0] = !(((this.inputValue[0] ^ this.inputValue[1]) ^ this.inputValue[2]) ^ this.inputValue[3]);
            };
        }
        XXXnor.compCount = 0;
        XXXnor.componentName = "xxxnor";
        return XXXnor;
    })(HTMLComponent);
    Components.XXXnor = XXXnor;
	//========== XNOR GATE (4-input) ==========//	
})(Components || (Components = {}));

jsPlumb.ready(function () {
    jsPlumb.setContainer($("#screen"));
    jsPlumb.doWhileSuspended(function () {
        jsPlumb.bind("connection", function (info, originalEvent) {
            var sourceid = info.source.id;
            var targetid = info.target.id;
            var sourceepid = +(info.sourceEndpoint.id.split("-")[1].substring(1));
            var targetepid = +(info.targetEndpoint.id.split("-")[1].substring(1));
            console.log("Connection detached from ", sourceid, "(", sourceepid, ") to ", targetid, "(", targetepid, ").");
            Simulator.connect(Simulator.getComponent(sourceid), sourceepid, Simulator.getComponent(targetid), targetepid);
        });
        jsPlumb.bind("connectionDetached", function (info, originalEvent) {
            var sourceid = info.source.id;
            var targetid = info.target.id;
            var sourceepid = +(info.sourceEndpoint.id.split("-")[1].substring(1));
            var targetepid = +(info.targetEndpoint.id.split("-")[1].substring(1));
            console.log("Connection detached from ", sourceid, "(", sourceepid, ") to ", targetid, "(", targetepid, ").");
            Simulator.disconnect(Simulator.getComponent(sourceid), sourceepid, Simulator.getComponent(targetid), targetepid);
        });
        jsPlumb.bind("connectionMoved", function (info, originalEvent) {
            var sourceid = info.originalSourceId;
            var targetid = info.originalTargetId;
            var sourceepid = +(info.originalSourceEndpoint.id.split("-")[1].substring(1));
            var targetepid = +(info.originalTargetEndpoint.id.split("-")[1].substring(1));
            console.log("Connection detached from ", sourceid, "(", sourceepid, ") to ", targetid, "(", targetepid, ").");
            Simulator.disconnect(Simulator.getComponent(sourceid), sourceepid, Simulator.getComponent(targetid), targetepid);
        });
    });
});
