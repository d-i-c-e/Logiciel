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
    /// Logique d'interaction pour HomePage.xaml
    /// </summary>
    public partial class HomePage : Page
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
        public HomePage()
        {
            InitializeComponent();
        }
        #endregion

        #region StaticFunctions
        #endregion

        #region Functions
        #endregion

        #region Events
        private void profile_Click(object sender, RoutedEventArgs e)
        {
            (this.Parent as Window).Content = new ProfilePage();
        }

        private void parameter_Click(object sender, RoutedEventArgs e)
        {
            (this.Parent as Window).Content = new ParameterPage();
        }

        private void logout_Click(object sender, RoutedEventArgs e)
        {
            (this.Parent as Window).Content = new LoginPage();
        }

        private void createGame_Click(object sender, RoutedEventArgs e)
        {
            (this.Parent as Window).Content = new CreateGamePage();
        }

        private void createCard_Click(object sender, RoutedEventArgs e)
        {
            (this.Parent as Window).Content = new CreateCardPage();
        }

        private void joinGame_Click(object sender, RoutedEventArgs e)
        {
            (this.Parent as Window).Content = new JoinGamePage();
        }

        private void ressource_Click(object sender, RoutedEventArgs e)
        {
            (this.Parent as Window).Content = new RessourcePage();
        }
        #endregion
    }
}
