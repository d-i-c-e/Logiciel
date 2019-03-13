using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace Dice.Views
{
    /// <summary>
    /// Logique d'interaction pour LoginPage.xaml
    /// </summary>
    public partial class LoginPage : Page
    {

        #region StaticVariables
        #endregion

        #region Constants
        #endregion

        #region Variables
        #endregion

        #region Attributs
        #endregion

        #region Properties
        #endregion

        #region Constructors
        /// <summary>
        /// Default constructor.
        /// </summary>
        public LoginPage()
        {
            InitializeComponent();
        }
        #endregion

        #region StaticFunctions
        #endregion

        #region Functions
        #endregion

        #region Events
        private void loginClick(object sender, RoutedEventArgs e)
        {
            string accountStatus = "unknow";
            string loginText = this.loginTxt.Text;
            string passwordText = this.passwordTxt.Text;

            // test compte BDD
            if (loginText == "John Doe" && passwordText == "P@ssword")
            {
                accountStatus = "know";
            }

            if (accountStatus == "know")
            {
                (this.Parent as Window).Content = new HomePage();
            }
            else
            {
                // texte erreur
            }
        }
        #endregion

    }
}
