/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.GUI;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.time.LocalDate;
import java.time.temporal.ChronoUnit;
import java.util.List;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
import javafx.scene.control.Label;
import javafx.scene.control.TableView;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.HBox;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import javax.swing.JOptionPane;
import tn.esprit.YoTalent.entities.Categorie;
import tn.esprit.YoTalent.services.ServiceCategorie;
import tn.esprit.YoTalent.services.ServiceET;
import tn.esprit.YoTalent.utils.MaConnexion;

/**
 * FXML Controller class
 *
 * @author sarra
 */
public class InterfaceCategoryController implements Initializable {
     @FXML
    private TableView<Categorie> AfficherC;
    ServiceCategorie es=new ServiceCategorie();
     Categorie e = new Categorie();
 ObservableList<Categorie> categorie ;
      private boolean isLightMode =true;
    @FXML
    private Button ExitCat;
    @FXML
    private TextField IdCat;
    @FXML
    private TextField NomCat;
    @FXML
    private Button Modify;
    
    @FXML
    private TableColumn<Categorie, Integer> colIdCat;
    @FXML
    private TableColumn<Categorie, String> colNom;
    @FXML
    private TextField DeleteCat;
    @FXML
    private Button Delete;
    @FXML
    private ImageView NextCat;
    @FXML
    private Button AddCat;
    @FXML
    private ImageView PrevCat;
    private Connection cnx;
    

    public InterfaceCategoryController(){
        cnx = MaConnexion.getInstance().getCnx();
        
    }
    

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
         AfficherC.setFocusTraversable(false);
        try {
            getEST();
        } catch (SQLException ex) {
            Logger.getLogger(InterfaceCategoryController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }    
    
    public void getEST() throws SQLException {
     
       
    
     
   colIdCat.setCellValueFactory(new PropertyValueFactory<Categorie,Integer>("idCat"));
   colNom.setCellValueFactory(new PropertyValueFactory<Categorie,String>("nomCat"));
  
    ServiceCategorie es=new ServiceCategorie();
       categorie= es.FetchCat();
        System.out.println(categorie);
        AfficherC.setItems(categorie); 
    }
    

    @FXML
    private void Modify_Button(ActionEvent event) {
    try{
        // check if input fields are empty
        if (IdCat.getText().isEmpty() || NomCat.getText().isEmpty()) {
            Alert alert = new Alert(AlertType.ERROR);
            alert.setTitle("Error ");
            alert.setHeaderText("Error!");
            alert.setContentText("Fields cannot be empty");
            alert.showAndWait();
            return;
        }
        
        // check if idCat is a valid integer
        int idCat;
        try {
            idCat = Integer.parseInt(IdCat.getText());
        } catch (NumberFormatException e) {
            Alert alert = new Alert(AlertType.ERROR);
            alert.setTitle("Error ");
            alert.setHeaderText("Error!");
            alert.setContentText("Invalid value for idCat");
            alert.showAndWait();
            return;
        }
        
        // create Categorie object with input values
        Categorie up = new Categorie(idCat, NomCat.getText());
        es.updateOne(up);
        
        // show success message and refresh table view
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Information ");
        alert.setHeaderText("Categorie update");
        alert.setContentText("Categorie updated successfully!");
        alert.showAndWait();
        getEST();
        
        // clear input fields
        IdCat.clear();
        NomCat.clear();
        
    } catch(Exception ex){
        System.out.println("fama ghalta2");
    }
}


    @FXML
    private void Delete_Button(ActionEvent event) throws SQLException {
        
          Categorie e1 = AfficherC.getItems().get(AfficherC.getSelectionModel().getSelectedIndex());
      
        try {
            es.deletOne(e1);
        } catch (SQLException ex) {
            Logger.getLogger(InterfaceCategoryController.class.getName()).log(Level.SEVERE, null, ex);
        }
         Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("Categorie delete");
            alert.setContentText("Categorie deleted successfully!");
            alert.showAndWait();
         getEST();
       
    }

    @FXML
    private void AddCat_Button(ActionEvent event) throws SQLException {
         // Vérifier que l'ID de catégorie est un entier positif
   
    
    // Vérifier que le nom de catégorie n'est pas vide
    String nomCat = NomCat.getText().trim();
    if (nomCat.isEmpty()) {
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Error");
        alert.setHeaderText("Invalid category name");
        alert.setContentText("Please enter a non-empty name for category.");
        alert.showAndWait();
        return;
    }
    
    // Créer une nouvelle instance de Categorie avec les valeurs saisies
    Categorie ev = new Categorie(nomCat);
    es.createOne(ev);
    getEST();
    
    // Afficher une boîte de dialogue pour confirmer l'ajout de la catégorie
    Alert alert = new Alert(AlertType.INFORMATION);
    alert.setTitle("Information");
    alert.setHeaderText("Category added");
    alert.setContentText("Category has been added successfully.");
    alert.showAndWait();
    }

@FXML
private void handleArrowImageClickC(MouseEvent event) throws IOException {
    Parent nextScene = FXMLLoader.load(getClass().getResource("InterfVideo.fxml"));
    Scene scene = new Scene(nextScene);
    Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
    stage.setScene(scene);
    stage.show();
}

@FXML
private void handleBackArrowImageClickC(MouseEvent event) throws IOException {
    Parent previousScene = FXMLLoader.load(getClass().getResource("interfaceEST.fxml"));
    Scene scene = new Scene(previousScene);
    Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
    stage.setScene(scene);
    stage.show();
}


}
    

