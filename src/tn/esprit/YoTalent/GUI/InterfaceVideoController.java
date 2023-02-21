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
import javafx.scene.Parent;
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
    private ImageView NextVid;
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
     
       
         Video up=new Video(Integer.valueOf(this.IdVid.getText()),this.NomVid.getText(),this.UrlVid.getText());
         es.updateOne(up);
            Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("Video update");
            alert.setContentText("Video updated successfully!");
            alert.showAndWait();
            getVid();
        } catch(Exception ex){
            System.out.println("fama ghalta2");
        }
         IdVid.clear();
       NomVid.clear();
       UrlVid.clear();
       
        
    }

    @FXML
    private void AddVid_Button(ActionEvent event) throws SQLException {
           String nomVid,urlVid;
        //BeginsAtdate.setValue(LocalDate.now());
         if ((NomVid.getText().length()==0) || (UrlVid.getText().length()==0))
                { Alert alert = new Alert(AlertType.ERROR);
                   alert.setTitle("Error ");
                    alert.setHeaderText("Error!");
                    alert.setContentText("Fields cannot be empty");
                    alert.showAndWait();}
         
         
         else{
             
           
           try{
            nomVid = String.valueOf(NomVid.getText());
              urlVid = String.valueOf(UrlVid.getText());
          
        }catch(Exception exc){
            System.out.println("name exception");
            return;
        }  
            
            Video ev=new Video(NomVid.getText(),UrlVid.getText());
         
   
         es.createOne(ev);
         getVid();
          //FXMLLoader loader = new FXMLLoader(getClass().getResource("DisplayEvents.fxml"));
          Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("EspaceTalent add");
            alert.setContentText("EspaceTalent added successfully!");
            alert.showAndWait();
         }
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
    
}
