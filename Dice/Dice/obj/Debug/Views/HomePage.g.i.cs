﻿#pragma checksum "..\..\..\Views\HomePage.xaml" "{8829d00f-11b8-4213-878b-770e8597ac16}" "DE633CBC930053CE0DEFD46CFF9E7EA5CD1CADBE58F2C0A0479B564597A880C1"
//------------------------------------------------------------------------------
// <auto-generated>
//     Ce code a été généré par un outil.
//     Version du runtime :4.0.30319.42000
//
//     Les modifications apportées à ce fichier peuvent provoquer un comportement incorrect et seront perdues si
//     le code est régénéré.
// </auto-generated>
//------------------------------------------------------------------------------

using Dice.Views;
using System;
using System.Diagnostics;
using System.Windows;
using System.Windows.Automation;
using System.Windows.Controls;
using System.Windows.Controls.Primitives;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Markup;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Media.Effects;
using System.Windows.Media.Imaging;
using System.Windows.Media.Media3D;
using System.Windows.Media.TextFormatting;
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Windows.Shell;


namespace Dice.Views {
    
    
    /// <summary>
    /// HomePage
    /// </summary>
    public partial class HomePage : System.Windows.Controls.Page, System.Windows.Markup.IComponentConnector {
        
        
        #line 39 "..\..\..\Views\HomePage.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Button parameterBtn;
        
        #line default
        #line hidden
        
        
        #line 44 "..\..\..\Views\HomePage.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Button profileBtn;
        
        #line default
        #line hidden
        
        
        #line 49 "..\..\..\Views\HomePage.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Button logoutBtn;
        
        #line default
        #line hidden
        
        
        #line 71 "..\..\..\Views\HomePage.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Button createGameBtn;
        
        #line default
        #line hidden
        
        
        #line 72 "..\..\..\Views\HomePage.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Button createCardBtn;
        
        #line default
        #line hidden
        
        
        #line 73 "..\..\..\Views\HomePage.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Button joinGameBtn;
        
        #line default
        #line hidden
        
        
        #line 74 "..\..\..\Views\HomePage.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Button ressourceBtn;
        
        #line default
        #line hidden
        
        private bool _contentLoaded;
        
        /// <summary>
        /// InitializeComponent
        /// </summary>
        [System.Diagnostics.DebuggerNonUserCodeAttribute()]
        [System.CodeDom.Compiler.GeneratedCodeAttribute("PresentationBuildTasks", "4.0.0.0")]
        public void InitializeComponent() {
            if (_contentLoaded) {
                return;
            }
            _contentLoaded = true;
            System.Uri resourceLocater = new System.Uri("/Dice;component/views/homepage.xaml", System.UriKind.Relative);
            
            #line 1 "..\..\..\Views\HomePage.xaml"
            System.Windows.Application.LoadComponent(this, resourceLocater);
            
            #line default
            #line hidden
        }
        
        [System.Diagnostics.DebuggerNonUserCodeAttribute()]
        [System.CodeDom.Compiler.GeneratedCodeAttribute("PresentationBuildTasks", "4.0.0.0")]
        [System.ComponentModel.EditorBrowsableAttribute(System.ComponentModel.EditorBrowsableState.Never)]
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Design", "CA1033:InterfaceMethodsShouldBeCallableByChildTypes")]
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Maintainability", "CA1502:AvoidExcessiveComplexity")]
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1800:DoNotCastUnnecessarily")]
        void System.Windows.Markup.IComponentConnector.Connect(int connectionId, object target) {
            switch (connectionId)
            {
            case 1:
            this.parameterBtn = ((System.Windows.Controls.Button)(target));
            
            #line 39 "..\..\..\Views\HomePage.xaml"
            this.parameterBtn.Click += new System.Windows.RoutedEventHandler(this.parameter_Click);
            
            #line default
            #line hidden
            return;
            case 2:
            this.profileBtn = ((System.Windows.Controls.Button)(target));
            
            #line 44 "..\..\..\Views\HomePage.xaml"
            this.profileBtn.Click += new System.Windows.RoutedEventHandler(this.profile_Click);
            
            #line default
            #line hidden
            return;
            case 3:
            this.logoutBtn = ((System.Windows.Controls.Button)(target));
            
            #line 49 "..\..\..\Views\HomePage.xaml"
            this.logoutBtn.Click += new System.Windows.RoutedEventHandler(this.logout_Click);
            
            #line default
            #line hidden
            return;
            case 4:
            this.createGameBtn = ((System.Windows.Controls.Button)(target));
            
            #line 71 "..\..\..\Views\HomePage.xaml"
            this.createGameBtn.Click += new System.Windows.RoutedEventHandler(this.createGame_Click);
            
            #line default
            #line hidden
            return;
            case 5:
            this.createCardBtn = ((System.Windows.Controls.Button)(target));
            
            #line 72 "..\..\..\Views\HomePage.xaml"
            this.createCardBtn.Click += new System.Windows.RoutedEventHandler(this.createCard_Click);
            
            #line default
            #line hidden
            return;
            case 6:
            this.joinGameBtn = ((System.Windows.Controls.Button)(target));
            
            #line 73 "..\..\..\Views\HomePage.xaml"
            this.joinGameBtn.Click += new System.Windows.RoutedEventHandler(this.joinGame_Click);
            
            #line default
            #line hidden
            return;
            case 7:
            this.ressourceBtn = ((System.Windows.Controls.Button)(target));
            
            #line 74 "..\..\..\Views\HomePage.xaml"
            this.ressourceBtn.Click += new System.Windows.RoutedEventHandler(this.ressource_Click);
            
            #line default
            #line hidden
            return;
            }
            this._contentLoaded = true;
        }
    }
}

