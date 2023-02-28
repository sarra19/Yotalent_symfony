/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.GUI;

import java.io.IOException;
import java.net.MalformedURLException;
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
import tn.esprit.YoTalent.entities.Evenement;
import tn.esprit.YoTalent.services.ServiceEvent;
import javafx.scene.layout.HBox;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import javax.swing.JOptionPane;
import tn.esprit.YoTalent.entities.EspaceTalent;
import tn.esprit.YoTalent.entities.Video;
import tn.esprit.YoTalent.services.ServiceET;
import tn.esprit.YoTalent.services.ServiceVideo;
import tn.esprit.YoTalent.utils.MaConnexion;

/**
 * FXML Controller class
 *
 * @author sarra
 */
public class InterfaceVideoController implements Initializable {
     @FXML
    private TableView<Video> AfficherC;
    ServiceVideo es=new ServiceVideo();
     Video e = new Video();
 ObservableList<Video> video ;
      private boolean isLightMode =true;
    @FXML
    private Button ExitVid;
    @FXML
    private TextField IdVid;
    @FXML
    private TextField NomVid;
    @FXML
    private Button ModifyVid;
  
    @FXML
    private TableColumn<Video, Integer> colIdVid;
    @FXML
    private TableColumn<Video, String> colnomVid;
    @FXML
    private TableColumn<Video, String> colUrl;
    @FXML
    private TextField DeleteVid;

    @FXML
    private Button AddVid;
    @FXML
    private ImageView PrevVid;
    @FXML
    private TextField UrlVid;
    
    @FXML
    private Button ddVbtn;
    
     private Connection cnx;
    

    public InterfaceVideoController(){
        cnx = MaConnexion.getInstance().getCnx();
        
    }

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
      
         AfficherC.setFocusTraversable(false);
        try {
            getVid();
        } catch (SQLException ex) {
            Logger.getLogger(InterfaceVideoController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }    


     
       
    
     
    public void getVid() throws SQLException {
     
       
    
     
   colIdVid.setCellValueFactory(new PropertyValueFactory<Video,Integer>("idVid"));
   colnomVid.setCellValueFactory(new PropertyValueFactory<Video,String>("nomVid"));
   colUrl.setCellValueFactory(new PropertyValueFactory<Video,String>("url"));
  
    ServiceVideo es=new ServiceVideo();
       video= es.FetchVid();
        System.out.println(video);
        AfficherC.setItems(video); 
    }
    
    
   

   @FXML
private void ModifyVid_Button(ActionEvent event) {
    try{
        int idVid = Integer.parseInt(this.IdVid.getText());
        if (idVid < 0) {
            throw new NumberFormatException("ID must be a positive integer");
        }
        
        String nomVid = this.NomVid.getText().trim();
        if (nomVid.isEmpty()) {
            throw new IllegalArgumentException("Name cannot be empty");
        }
        
        String urlVid = this.UrlVid.getText().trim();
        if (urlVid.isEmpty()) {
            throw new IllegalArgumentException("URL cannot be empty");
        }
        
        Video up=new Video(idVid, nomVid, urlVid);
        es.updateOne(up);
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Information ");
        alert.setHeaderText("Video update");
        alert.setContentText("Video updated successfully!");
        alert.showAndWait();
        getVid();
    } catch (NumberFormatException ex) {
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Error");
        alert.setHeaderText("Invalid ID");
        alert.setContentText("ID must be a positive integer");
        alert.showAndWait();
    } catch (IllegalArgumentException ex) {
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Error");
        alert.setHeaderText("Invalid input");
        alert.setContentText(ex.getMessage());
        alert.showAndWait();
    } catch(Exception ex){
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Error");
        alert.setHeaderText("Video update failed");
        alert.setContentText("An error occurred while updating the video");
        alert.showAndWait();
    }
    
    IdVid.clear();
    NomVid.clear();
    UrlVid.clear();   
}

    @FXML
private void AddVid_Button(ActionEvent event) throws SQLException, MalformedURLException {
    String nomVid = NomVid.getText().trim();
    String urlVid = UrlVid.getText().trim();
    
    // Vérifier que le nomVid n'est pas vide et ne contient pas de chiffres
    if (nomVid.isEmpty() || nomVid.matches(".*\\d.*")) {
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Error");
        alert.setHeaderText("Invalid Name");
        alert.setContentText("Please enter a valid name (no numbers allowed).");
        alert.showAndWait();
        return;
    }
    
    // Vérifier que l'urlVid est une URL valide
    try {
        URL url = new URL(urlVid);
    } catch (MalformedURLException e) {
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Error");
        alert.setHeaderText("Invalid URL");
        alert.setContentText("Please enter a valid URL.");
        alert.showAndWait();
        return;
    }
    
    Video ev = new Video(nomVid, urlVid);
    es.createOne(ev);
    getVid();
    
    Alert alert = new Alert(AlertType.INFORMATION);
    alert.setTitle("Information");
    alert.setHeaderText("Video Added");
    alert.setContentText("Video added successfully!");
    alert.showAndWait();
}



    @FXML
    private void ddVbtn(ActionEvent event) throws SQLException {
         
         Video e1 = AfficherC.getItems().get(AfficherC.getSelectionModel().getSelectedIndex());
      
        try {
            es.deletOne(e1);
        } catch (SQLException ex) {
            Logger.getLogger(InterfaceVideoController.class.getName()).log(Level.SEVERE, null, ex);
        }
         Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("Video delete");
            alert.setContentText("Video deleted successfully!");
            alert.showAndWait();
         getVid();
       
    }
    
    @FXML
private void handleBackArrowImageClickV(MouseEvent event) throws IOException {
    Parent previousScene = FXMLLoader.load(getClass().getResource("InterfaceCategory.fxml"));
    Scene scene = new Scene(previousScene);
    Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
    stage.setScene(scene);
    stage.show();
}
}
